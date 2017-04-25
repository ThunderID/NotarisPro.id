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
	public function create($id = null)
	{
		if (!is_null($id)) 
		{
			$this->page_attributes->title		= 'Edit Template';

			$this->page_datas->id 				= $id;
		}
		else 
		{
			$this->page_attributes->title		= 'Tambah Template';

			$this->page_datas->datas			= null;
			$this->page_datas->id 				= null;
		}

		// get list widgets
		$this->page_datas->list_widgets 	= $this->list_widgets();
		
		//initialize view
		$this->view							= view('pages.akta.template.create');

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
		//
		 try {
			// get data
			$input		= $request->only(
									'title', 
									'template'
								);

			$pattern = "/<h4.*?>(.*?)<\/h4>|<p.*?>(.*?)<\/p>|(<(ol|ul).*?><li>(.*?)<\/li>)|(<li>(.*?)<\/li><\/(ol|ul)>)/i";
			preg_match_all($pattern, $input['template'], $out, PREG_PATTERN_ORDER);
			// change key index like 'paragraph[*]'

			foreach ($out[0] as $key => $value) 
			{
				$input['paragraf'][$key]['konten']	= $value;
				
				$pattern_2 = '/<b class="medium-editor-mention-at.*?>(.*?)<\/b>/i';
		
				if(preg_match_all($pattern_2, $value, $matches)) 
				{
					if(!isset($input['mentionable']))
					{
						if(is_array($matches[1]))
						{
							foreach ($matches[1] as $keyx => $valuex) 
							{
								if(str_is('@*', $valuex))
								{
									$input['mentionable'][]	= $valuex;
								}
							}
						}
						else
						{
							if(str_is('@*', $valuex))
							{
								$input['mentionable'][]	= $matches[1];
							}
								
						}
					}
					elseif(!is_array($matches['1']) && !in_array($matches[1], $input['mentionable']))
					{
						$input['mentionable'][]	= $matches[1];
					}
					elseif(is_array($matches['1']))
					{
						$new_array 				= [];
						foreach ($matches[1] as $keyx => $valuex) 
						{
							if(str_is('@*', $valuex))
							{
								$new_array[]	= $valuex;
							}
						}
						$input['mentionable']	= 
						array_merge(
							array_intersect($input['mentionable'], $new_array),		//         2   4
							array_diff($input['mentionable'], $new_array),			//       1   3
							array_diff($new_array, $input['mentionable'])			//               5 6
						);															//  $u = 1 2 3 4 5 6
					}
				}
			}

			$input['judul']							= $input['title'];

			// save
			$data                               	= new \TCommands\Akta\DraftingTemplateAkta($input);
			$data->handle();
		} catch (Exception $e) {
			$this->page_attributes->msg['error']	= $e->getMessage();
		}

		//return view
        if($id == null){
            $this->page_attributes->msg['success']         = ['Data template telah ditambahkan'];
            return $this->generateRedirect(route('akta.template.index'));
        }else{
            $this->page_attributes->msg['success']         = ['Data template telah diperbarui'];
            return $this->generateRedirect(route('akta.template.show', ['id' => $id]));
        }
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$template         = new \TQueries\Akta\DaftarTemplateAkta;
		$template         = $template->detailed($id);

		$this->page_attributes->title			= $template['judul'];

		$this->page_datas->datas['template']	= $template;

		//initialize view
		$this->view							= view('pages.akta.template.show');

		//function from parent to generate view
		return $this->generateView();  
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
