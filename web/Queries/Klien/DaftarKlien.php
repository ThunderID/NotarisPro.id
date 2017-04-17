<?php

namespace TQueries\Klien;

///////////////
//   Models  //
///////////////
use TKlien\Klien\Models\Klien as Model;

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
class DaftarKlien
{
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
		}
		else
		{
			$queries['take']	= 15;
		}

		if(isset($queries['page']))
		{
			$queries['skip']	= (($queries['page'] - 1) * $queries['take']);
		}
		else
		{
			$queries['skip']	= 0;
		}
		
		$model  				= $model->skip($queries['skip'])->take($queries['take'])->orderby('created_at', 'desc')->get()->toArray();

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
		$model 			= $this->model->id($id)->first();

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
	
	private function queries($queries)
	{
		$model 					= $this->model;
		
		//1.allow kantor
		$queries['kantor_id']	= [TAuth::activeOffice()['kantor']['id'], "0"];

		$model  				= $model->kantor($queries['kantor_id']);

		//2.allow nama
		if(isset($queries['nama']))
		{
			$model  			= $model->nama($queries['nama']);
		}

		//3.sort nama
		if(isset($queries['urutkan']))
		{
			foreach ($queries['urutkan'] as $key => $value) 
			{
				switch (strtolower($key)) 
				{
					case 'nama':
						$model  			= $model->orderby('nama', $value);
						break;
					default:
						$model  			= $model->orderby('nama', 'asc');
						break;
				}
			}
		}
		else
		{
			$model  			= $model->orderby('nama', 'asc');
		}
		
		return $model;
	} 
}
