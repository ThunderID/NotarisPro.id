<?php

namespace App\Service\Akta;

///////////////
//   Models  //
///////////////
use App\Domain\Akta\Models\Dokumen as Model;

use App\Domain\Akta\Models\Versi;
use App\Domain\Akta\Models\ReadOnlyAkta;

use Hash, Exception, Session, TAuth;

/**
 * Class Services Application
 *
 * Meyimpan visa dari user tertentu.
 *
 * @package    Thunderlabid
 * @subpackage Application
 * @author     C Mooy <chelsy@thunderlab.id>
 */
class DaftarAkta
{
	public $per_page 	= 15;
	public $page 		= 1;

	public function __construct()
	{
		$this->model 		= new Model;
	}

	/**
	 * this function mean keep executing
	 * @param array $data
	 * 
	 * @return array $data
	 */
	public function get($queries = [])
	{
		$model 		= $this->queries($queries);

		//2. pagination
		if(isset($queries['per_page']))
		{
			$queries['take']	= $queries['per_page'];
			$this->per_page 	= $queries['per_page'];
		}
		else
		{
			$queries['take']	= 15;
		}

		if(isset($queries['page']))
		{
			$queries['skip']	= (($queries['page'] - 1) * $queries['take']);
			$this->page 		= $queries['page'];
		}
		else
		{
			$queries['skip']	= 0;
		}
		
		$model  				= $model->skip($queries['skip'])->take($queries['take'])->get(['judul', 'status', 'pemilik', 'penulis', 'created_at', 'updated_at'])->toArray();

		return 	$model;
	}

	/**
	 * this function mean keep executing
	 * @param array $data
	 * 
	 * @return array $data
	 */
	public function detailed($id)
	{
		$model 		= $this->queries([]);
		$model 		= $model->id($id)->first();

		$akta 		= $model->toArray();

		if($akta['status']=='akta')
		{
			$version 				= ReadOnlyAkta::where('original_id', $id)->first();
			$akta['paragraf']		= [['konten' => $version['paragraf']]];
		}

		if(!isset($akta['fill_mention']))
		{
			$akta['fill_mention']	= null;
		}
		foreach ((array)$akta['fill_mention'] as $key => $value) 
		{
			$akta['fill_mention']['@'.str_replace('-+','.',$key)] = $value;
			unset($akta['fill_mention'][$key]);
		}

		return $akta;
	}


	public function versioning($id)
	{
		$model 		= $this->queries([]);
		$model 		= $model->id($id)->first();

		$original 	= $model->toArray();

		unset($original['mentionable']);
		unset($original['fill_mention']);

		$prev_version 	= Versi::where('original_id', $original['id'])->orderby('versi', 'desc')->skip(1)->first()->toArray();

		unset($prev_version['mentionable']);
		unset($prev_version['fill_mention']);

		return ['id' => $id, 'terbaru' => $original, 'original' => $prev_version];
	}

	/**
	 * this function mean keep executing
	 * @param array $data
	 * 
	 * @return UserDTODataTransformer $data
	 */
	public function count($queries = [])
	{
		$model 		= $this->queries($queries);
		$model		= $model->count();

		return 	$model;
	}
	
	/**
	 * this function mean keep executing
	 * @param numeric $page
	 * 
	 * @return CreditDTODataTransformer $data
	 */
	private function statusLists($role)
	{
		switch (strtolower($role)) 
		{
			case 'notaris':
				return ['draft', 'pengajuan', 'renvoi', 'akta', 'minuta'];
				break;
			case 'drafter':
				return ['draft', 'renvoi'];
				break;
			
			default:
				throw new Exception("Forbidden", 1);
				break;
		}
	}

	private function queries($queries)
	{
		$active_office 			= TAuth::activeOffice();

		$model 					= $this->model;

		//1.allow status
		if(isset($queries['status']))
		{
			if(!in_array($queries['status'], $this->statusLists($active_office['role'])))
			{
				throw new Exception("Forbidden", 1);
				
			}
		}
		else
		{
			$queries['status']	= $this->statusLists($active_office['role']);
		}
		$model  				= $model->status($queries['status']);

		//2.allow kantor
		$queries['kantor_id']	= [$active_office['kantor']['id'], "0"];

		$model  				= $model->kantor($queries['kantor_id']);

		//3.allow owner
		$queries['pemilik_id']	= TAuth::loggedUser()['id'];
		$model  				= $model->pemilik($queries['pemilik_id']);

		//4.allow klien
		if(isset($queries['klien']))
		{
			$model  			= $model->klien($queries['klien']);
		}

		//5.allow judul
		if(isset($queries['judul']))
		{
			$model  			= $model->judul($queries['judul']);
		}
		
		//6.sort klien
		if(isset($queries['urutkan']))
		{
			foreach ($queries['urutkan'] as $key => $value) 
			{
				switch (strtolower($key)) 
				{
					case 'judul':
						$model  			= $model->orderby('judul', $value);
						break;
					case 'status':
						$model  			= $model->orderby('status', $value);
						break;
					case 'tanggal_pembuatan':
						$model  			= $model->orderby('created_at', $value);
						break;
					case 'tanggal_sunting':
						$model  			= $model->orderby('updated_at', $value);
						break;
					default:
						$model  			= $model->orderby('updated_at', 'desc');
						break;
				}
			}
		}
		else
		{
			$model  			= $model->orderby('updated_at', 'desc');
		}

		return $model;
	} 
}
