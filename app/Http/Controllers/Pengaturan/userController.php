<?php

namespace App\Http\Controllers\Pengaturan;

use App\Http\Controllers\Controller;
use App\Domain\Admin\Models\Pengguna as Query;

use App\Service\Helpers\JSend;

use Illuminate\Http\Request;

use TAuth, Exception, Carbon\Carbon, Validator;

use App\Infrastructure\Traits\GuidTrait;

class userController extends Controller
{
	use GuidTrait;

	public function __construct(Query $query)
	{
		parent::__construct();
		
		$this->query            = $query;
		$this->per_page 		= (int)env('DATA_PERPAGE');
	}   

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$this->active_office 				= TAuth::activeOffice();

		// 1. set page attributes
		$this->page_attributes->title		= 'User';

		// 2. call all users data needed
		//2a. parse query searching
		$query 								= $request->only('cari', 'filter', 'urutkan', 'page');

		//2b. retrieve all user
		$this->retrieveUser($query);

		//2c. get all filter 
		$this->page_datas->filters 			= $this->retrieveUserFilter();
		
		//2d. get all urutan 
		$this->page_datas->urutkan 			= $this->retrieveUserUrutkan();
		$this->page_datas->active_office 	= $this->active_office;

		//3.initialize view
		$this->view							= view('notaris.pages.pengaturan.user.index');

		return $this->generateView();  
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(Request $request, $id = null)
	{
		$this->active_office 				= TAuth::activeOffice();

		//2. init akta as null
		$this->page_datas->user 			= $this->query->id($id)->kantor($this->active_office['kantor']['id'])->first();

		if(!$this->page_datas->user || is_null($id))
		{
			$this->page_datas->user			= null;
		}

		$this->page_datas->id 				= $id;
		$this->page_datas->active_office	= $this->active_office;

		//2. set page attributes
		$this->page_attributes->title		= 'User';

		//3.initialize view
		$this->view							= view('notaris.pages.pengaturan.user.create');

		return $this->generateView();  
	}

	public function edit(Request $request, $id = null)
	{
		return $this->create($request, $id);
	}

	public function store(Request $request, $id = null)
	{
		try {
			//set this function
			$this->active_office= TAuth::activeOffice();
			$this->logged_user	= TAuth::loggedUser();

			//2. get store document
			$user				= $this->query->id($id)->kantor($this->active_office['kantor']['id'])->first();
			
			if(!$user || is_null($id))
			{
				$user 			= new $this->query;
				$password 		= rand(10000000,99999999);
				$user->password = $password;
			}

			if(str_is($request->get('user_role'), 'drafter'))
			{
				$scope 			= env('DRAFTER_SCOPE', '');
			}
			elseif(str_is($request->get('user_role'), 'manajer'))
			{
				$scope 			= env('MANAGER_SCOPE', '');
			}
			elseif(str_is($request->get('user_role'), 'notaris'))
			{
				$scope 			= env('NOTARIS_SCOPE', '');
			}

			$user->nama 		= $request->get('user_nama');
			$user->email 		= $request->get('user_email');
			$visas[0]			= [
									'id'			=> $this->createID('NEW'),
									'type'			=> $this->logged_user['visas'][0]['type'],
									'started_at'	=> Carbon::now()->format('Y-m-d H:i:s'),
									'expired_at'	=> $this->logged_user['visas'][0]['expired_at'],
									'role'			=> $request->get('user_role'),
									'scopes'		=> $scope,
									'kantor'		=> 	[
															'id'	=> $this->active_office['kantor']['id'],
															'nama'	=> $this->active_office['kantor']['nama'],
														]
								  ];
			$user->visas 		= $visas;
			$user->save();

			$this->page_attributes->msg['success']	= ['User Berhasil Disimpan. '.(isset($password) ? 'Password '.$user->nama.' '.$password : '')];
	
			return $this->generateRedirect(route('pengaturan.user.index'));
		} catch (Exception $e) {
			$this->page_attributes->msg['error']	= $e->getMessage();
			return $this->generateRedirect(route('pengaturan.user.edit', ['id' => $id]));
		}
	}

	public function update(Request $request, $id = null)
	{
		return $this->create($request, $id);
	}

	private function retrieveUser($query)
	{
		//1. pastikan berasal dari kantor yang sama
		$data 	 	= $this->query->kantor($this->active_office['kantor']['id']);

		//2. cari sesuai query
		if(isset($query['cari']))
		{
			$data 	= $data->where(function($q)use($query){$q->where('klien_nama', 'like', '%'.$query['cari'].'%')->orwhere('nomor', 'like', '%'.$query['cari'].'%');});
		}

		//3. filter 
		foreach ((array)$query['filter'] as $key => $value) 
		{
			if(in_array($key, ['status']))
			{
				$data 		= $data->where($key, $value);				
			}
		}

		//4. urutkan
		if(isset($query['urutkan']))
		{
			$explode 		= explode('-', $query['urutkan']);
			if(in_array($explode[0], ['tanggal_dikeluarkan', 'tanggal_jatuh_tempo', 'status', 'nama_klien']) && in_array($explode[1], ['asc', 'desc']))
			{
				$data 		= $data->orderby($key, $value);
			}
		}

		//5. page
		$skip 		= 0;
		if(isset($query['page']))
		{
			$skip 	= ((1 * $query['page']) - 1) * $this->per_page;
		}
		//set datas
		$this->paginate(null, $data->count(), $this->per_page);
		$this->page_datas->users 		= $data->skip($skip)->take($this->per_page)->get();
	}

	private function retrieveUserFilter()
	{
		//1a. cari jenis
		// $filter['jenis']	= $this->query->distinct('jenis')->get();

		//2a. status
		$filter['status']	= ['pending', 'lunas'];
	
		return $filter;
	}

	private function retrieveUserUrutkan()
	{
		//1a.cari urutan
		$sort	= 	[
						'created_at-desc' 	=> 'Terbaru dibuat',
						'created_at-asc' 	=> 'Terlama dibuat',
						'updated_at-desc' 	=> 'Terbaru diupdate',
						'updated_at-asc' 	=> 'Terlama diupdate',
					];

		return $sort;
	}
}
