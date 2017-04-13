<?php

namespace App\Http\Controllers\Akta;

use App\Http\Controllers\Controller;
use TQueries\Akta\DaftarAkta as Query;

use Request;

class aktaController extends Controller
{
	public function __construct(Query $query)
	{
		parent::__construct();
		
		$this->query            = $query;
	}    
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		// init
		$this->page_attributes->title		= 'Data Akta';

		//filter&search
        $query                             	= $this->getQueryString(['q','status', 'page']);
        $query['per_page']                 	= (int)env('DATA_PERPAGE');
        if(isset($query['judul'])){
	        $query['judul']					= $query['q'];
			unset($query['q']);    	
        }


        /*
        //1. untuk menampilkan data dengan filter status
        $filter['status']                   = 'draft';

        //2. untuk menampilkan data dengan pencarian nama klien
        $filter['klien']                    = 'Lili';

        //3. untuk menampilkan data dengan urutan judul
        $filter['urutkan']                  = ['judul' => 'desc'];
        //4. untuk menampilkan data dengan urutan status
        $filter['urutkan']                  = ['status' => 'desc'];
        //5. untuk menampilkan data dengan urutan tanggal pembuatan
        $filter['urutkan']                  = ['tanggal_pembuatan' => 'desc'];
        //6. untuk menampilkan data dengan urutan tanggal sunting
        $filter['urutkan']                  = ['tanggal_sunting' => 'desc'];
        */

		//get data from database
		$this->page_datas->datas			= $this->query->get($query);

        //paginate
        $this->paginate(null, $this->query->count($query), (int)env('DATA_PERPAGE'));        

		//initialize view
		$this->view							= view('pages.akta.akta.index');

		//function from parent to generate view
		return $this->generateView();  
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		// init
		$this->page_attributes->title       = 'Buat Akta';

		//get data from database
		$this->page_datas->datas            = null;

		//initialize view
		$this->view                         = view('pages.akta.akta.create');

		//function from parent to generate view
		return $this->generateView();  
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		//
	}
}
