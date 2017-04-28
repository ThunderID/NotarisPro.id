<?php

namespace TQueries\Akta;

///////////////
//   Models  //
///////////////
use TAkta\DokumenKunci\Models\Template as Model;

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
class DaftarTemplateAkta
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
		
		$model  				= $model->skip($queries['skip'])->take($queries['take'])->orderby('created_at', 'desc')->get(['judul', 'status', 'pemilik', 'penulis', 'created_at', 'updated_at'])->toArray();

		return 	$model;
	}

	/**
	 * this function mean keep executing
	 * @param array $data
	 * 
	 * @return UserDTODataTransformer $data
	 */
	public function all($queries = [])
	{
		$model 		= $this->queries($queries);
		
		$model		= $model->orderby('created_at', 'desc')->get(['judul', 'status', 'pemilik', 'penulis', 'created_at', 'updated_at'])->toArray();

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
		$queries['penulis']['id']	= TAuth::loggedUser()['id'];
		$model 						= $this->model->id($id)->draftOrPublished($queries)->first();
		$model 						= $model->toArray();

		if(!isset($model['paragraf']))
		{
			$model['paragraf']		= null;
		}

		return $model;
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

	private function queries($queries)
	{
		$model 					= $this->model;

		//1.allow kantor
		$queries['kantor_id']	= [TAuth::activeOffice()['kantor']['id'], "0"];

		$model  				= $model->kantor($queries['kantor_id']);

		//2.smart search status and writer id
		if(isset($queries['status']))
		{
			switch (strtolower($queries['status'])) 
			{
				case 'draft':
					$queries['penulis']['id']	= TAuth::loggedUser()['id'];
					$model  					= $model->draft($queries['penulis']['id']);
					break;
				case 'publish':
					$model  					= $model->status($queries['status']);
					break;
				default:
					$queries['penulis']['id']	= TAuth::loggedUser()['id'];
					$model  					= $model->draftOrPublished($queries);
					break;
			}
		}
		else
		{
			$queries['penulis']['id']	= TAuth::loggedUser()['id'];
			$model  					= $model->draftOrPublished($queries);
		}

		//3.allow judul
		if(isset($queries['judul']))
		{
			$model  					= $model->where('judul', $queries['judul']);
		}
		
		//4.sort klien
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
