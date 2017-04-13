<?php

namespace TQueries\Akta;

///////////////
//   Models  //
///////////////
use TAkta\DokumenKunci\Models\Dokumen as Model;

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
	 * @return UserDTODataTransformer $data
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
	 * @return UserDTODataTransformer $data
	 */
	public function detailed($id)
	{
		$model 		= $this->queries([]);
		$model 		= $model->id($id)->first();

		return $model->toArray();
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
	public function statusLists()
	{
		$current_user 	= TAuth::activeOffice();
		switch (strtolower($current_user['role'])) 
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
		$model 					= $this->model;

		//1.allow status
		if(isset($queries['status']))
		{
			if(!in_array($queries['status'], $this->statusLists()))
			{
				throw new Exception("Forbidden", 1);
				
			}
		}
		else
		{
			$queries['status']	= $this->statusLists();
		}
		$model  				= $model->status($queries['status']);
		
		//2.allow kantor
		$queries['kantor_id']	= [TAuth::activeOffice()['kantor']['id'], "0"];

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
