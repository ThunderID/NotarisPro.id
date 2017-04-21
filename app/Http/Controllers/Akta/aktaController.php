<?php

namespace App\Http\Controllers\Akta;

use App\Http\Controllers\Controller;

use TQueries\Akta\DaftarAkta as Query;
use TQueries\Akta\DaftarTemplateAkta;
use TQueries\Tags\TagService;

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
        $query                             	= $this->getQueryString(['q', 'status', 'sort', 'page']);
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

		if (Request::has('template_id'))
		{
			$template_id 					= Request::get('template_id'); 
		}
		else 
		{
			$template_id 					= null;
		}

		$call 								= new DaftarTemplateAkta;

		$filter         					= ['status' => 'publish'];
		$list_template 						= $call->get($filter);

		$this->page_datas->template_id 		= $template_id;
		$this->page_datas->datas			= $call->detailed($template_id);

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

	/**
	 * Function to choose template from new akta
	 */
	public function choose_template()
	{
		// init
		$this->page_attributes->title       = 'Pilih Template';

		$call 								= new DaftarTemplateAkta;

		$filter         					= ['status' => 'publish'];
		$list_template 						= $call->get($filter);

		//get data from database
		$this->page_datas->datas            = $list_template;

		//initialize view
		$this->view                         = view('pages.akta.akta.choosetemplate');

		//function from parent to generate view
		return $this->generateView();  
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
