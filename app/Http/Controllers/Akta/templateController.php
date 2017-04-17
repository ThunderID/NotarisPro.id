<?php

namespace App\Http\Controllers\Akta;

use Illuminate\Http\Request;
use TQueries\Akta\DaftarTemplateAkta as Query;
use TQueries\Tags\TagService;

use App\Http\Controllers\Controller;
use App\Http\Controllers\helperController;

class templateController extends Controller
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
		$this->page_attributes->title       = 'Template Akta';

		//filter&search
        $query                             	= $this->getQueryString(['q','status', 'page']);
        $query['per_page']                 	= (int)env('DATA_PERPAGE');

        // special treat judul
        if(isset($query['judul'])){
	        $query['judul']					= $query['q'];
			unset($query['q']);    	
        }

        // special treat sort
        if(isset($query['urutkan'])){
	        try{
				$sort 						= explode("-", $query['urutkan']);
				$query['urutkan'] 			= [ $sort[0] => $sort[1]]; 
			} catch (Exception $e) {
	        	// display error?
	        }
        }


		/*
		//1. untuk menampilkan data dengan filter status
		$filter['status']                   = 'draft';
		
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
		$this->page_datas->datas            = $this->query->get($query);

		//paginate
		$this->paginate(null, $this->query->count($query), (int)env('DATA_PERPAGE'));        

		//initialize view
		$this->view                         = view('pages.akta.template.index');

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
		$this->page_attributes->title       = 'Buat Template';

		//get data from database
		$this->page_datas->datas            = null;

		// get list widgets
		$this->page_datas->list_widgets 	= $this->list_widgets();
		
		//initialize view
		$this->view                         = view('pages.akta.template.create');

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

	/**
	 * function get list widgets on template create or edit
	 */
	private function list_widgets() 
	{
		$call 			= new TagService;
		$list 			= $call::all();

		$list 			= array_sort_recursive($list);

		return $list;
	}
}
