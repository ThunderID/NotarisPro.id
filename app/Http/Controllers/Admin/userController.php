<?php

namespace App\Http\Controllers\Admin;

use App\Service\Admin\DaftarPengguna as Query;
use App\Service\Admin\PenggunaBaru;
use App\Service\Admin\GrantVisa;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use TAuth, Redirect, URL;

class userController extends Controller
{
	public function __construct(Query $query)
	{
		parent::__construct();
		
		$this->query            = $query;
	}  

	public function index(){
		// init
		$this->page_attributes->title	= 'User';

		//get data from database
		$this->page_datas->datas		= $this->query->get(['per_page' => (int)env('DATA_PERPAGE')]);

		$this->paginate(null, $this->query->count(), (int)env('DATA_PERPAGE'));

		//initialize view
		$this->view						= view('pages.user.index');

		//function from parent to generate view
		return $this->generateView(); 
	}

	public function create()
	{
		// init
		$this->page_datas->id			= null;
		$this->page_attributes->title	= 'User Baru';

		//initialize view
		$this->view						= view('pages.user.create');

		//function from parent to generate view
		return $this->generateView(); 
	}
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store($id = null, Request $request)
	{
		try {
			// get data
			$input		= $request->only(
											'akun_nama', 
											'akun_email',
											'akun_role',
											'akun_password'
										);
			// save
			$data		= new PenggunaBaru($input['akun_nama'],$input['akun_email'],$input['akun_password']);
			$data 		= $data->handle();

			$grant 		= new GrantVisa($data['id'], $input['akun_role'], TAuth::activeOffice()['kantor']['id'], TAuth::activeOffice()['kantor']['nama']);
			$grant 		= $grant->handle();

		} catch (Exception $e) {
			$this->page_attributes->msg['error']       = $e->getMessage();
		}

		$this->page_attributes->msg['success']	= ['Data user telah diperbarui, billing akan mulai bertambah sesuai jumlah user'];

		return $this->generateRedirect(route('user.index', ['id' => $id]));
	}
}
