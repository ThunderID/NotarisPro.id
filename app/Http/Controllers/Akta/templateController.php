<?php

namespace App\Http\Controllers\Akta;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Service\Akta\DaftarTemplateAkta as Query;
use App\Service\Tag\TagService;
use App\Service\Tag\DokumenWajibService;
use App\Service\Akta\BuatTemplateBaru;
use App\Service\Akta\SimpanTemplate;
use App\Service\Akta\HapusTemplate;
use App\Service\Akta\PublishTemplate;

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
		$query                              = $this->getQueryString(['q','status', 'page']);
		$query['per_page']                  = (int)env('DATA_PERPAGE');

		// special treat judul
		if(isset($query['q'])){
			$query['judul']                 = $query['q'];
			unset($query['q']);     
		}

		// special treat sort
		if(isset($query['urutkan'])){
			try{
				$sort                       = explode("-", $query['urutkan']);
				$query['urutkan']           = [ $sort[0] => $sort[1]]; 
			} catch (Exception $e) {
				// display error?
			}
		}

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
		// try {
		// 	$input['judul']		= 'Tidak ada judul [Untitled]';

		// 	// save
		// 	$data				= new \TCommands\Akta\dalam_prosesingTemplateAkta($input);
		// 	$data				= $data->handle();
		// // save
		// } catch (Exception $e) {
		// 	$this->page_attributes->msg['error']	= $e->getMessage();
		// 	return $this->generateRedirect(route('akta.template.index'));
		// }

		// $this->page_attributes->msg['success']         = ['Data template telah di generate'];

		// return $this->generateRedirect(route('akta.template.edit', $data['id']));

		$this->page_attributes->title       = 'Buat Template Dokumen Baru';

		$this->page_datas->id 				= null;

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
	public function store($id = null, Request $request)
	{
		//
		try {

			$paragraph		= $this->parse_store($id, $request);

			$akta			= new BuatTemplateBaru($paragraph['judul'], $request->get('deskripsi'), $paragraph['paragraf'], $paragraph['mentionable'], $request->get('jumlah_pihak'), $request->get('dokumen_objek'), $request->get('dokumen_pihak'), $request->get('dokumen_saksi'));
	
			$akta 			= $akta->handle();		

		} catch (Exception $e) {
			$this->page_attributes->msg['error']    = $e->getMessage();
		}

		//return view
		if($id == null){
			$this->page_attributes->msg['success']         = ['Data template telah ditambahkan'];
			return $this->generateRedirect(route('akta.template.edit', ['id' => $akta['id']]));
		}else{
			$this->page_attributes->msg['success']         = ['Data template telah diperbarui'];
			return $this->generateRedirect(route('akta.template.create'));
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
		$this->page_datas->datas			= $this->query->detailed($id);
		$this->page_attributes->title       = $this->page_datas->datas['judul'];

		//initialize view
		$this->view                         = view('pages.akta.template.show');

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
		$this->page_attributes->title       = 'Edit Template';
		$this->page_datas->id               = $id;
		$this->page_datas->datas			= $this->query->detailed($id);

		// get list widgets
		$this->page_datas->list_widgets     = $this->list_widgets($this->page_datas->datas);

		//initialize view
		$this->view                         = view('pages.akta.template.create');

		//function from parent to generate view
		return $this->generateView();  
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update($id, Request $request)
	{
		//
		try {
			$content 	= $this->parse_store($id, $request);
			$akta 		= new SimpanTemplate($id, $content['paragraf'], $content['mentionable']);
			$akta 		= $akta->handle();	
		} catch (Exception $e) {
			$this->page_attributes->msg['error']    = $e->getMessage();
		}

		//return view
		if($id == null){
			$this->page_attributes->msg['success']         = ['Data template telah ditambahkan'];
			return $this->generateRedirect(route('akta.template.edit', ['id' => $akta['id']]));
		}else{
			$this->page_attributes->msg['success']         = ['Data template telah diperbarui'];
			return $this->generateRedirect(route('akta.template.show', ['id' => $akta['id']]));
		}
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function publish($id, Request $request)
	{
		try {
			// save
			$data									= new PublishTemplate($id);
			$data->handle();
		} catch (Exception $e) {
			$this->page_attributes->msg['error']	= $e->getMessage();
		}

		//return view
		$this->page_attributes->msg['success']         = ['Template akta telah di publish, sekarang semua user di kantor dapat menggunakan template ini'];
		return $this->generateRedirect(route('akta.template.show', $id));
	}
		/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		// cek apa password benar

		// hapus
		try {
			$template								= new HapusTemplate($id);
			$template								= $template->handle();
		} catch (Exception $e) {
			$this->page_attributes->msg['error']	= $e->getMesssage();
		}            

		$this->page_attributes->msg['success']		= ['Data template telah dihapus'];

		//return view
		return $this->generateRedirect(route('akta.template.index'));
	}

	/**
	 * function automatic save
	 */
	public function automatic_store ($id = null, Request $request)
	{
		try {
			$content 	= $this->parse_store($id, $request);
			$akta 		= new SimpanTemplate($id, $content['paragraf'], $content['mentionable']);
			$akta 		= $akta->handle();
		} catch (Exception $e) {
			return response()->json(['status'	=> $e->getMessage()], 200);
		}

		// return value json
		if ($id == null) {
		    $this->page_attributes->msg['success']         = ['Data template telah ditambahkan'];
		    return response()->json(['status'	=> 'success'], 200);
		} else {
		    $this->page_attributes->msg['success']         = ['Data template telah diperbarui'];
		    return response()->json(['status'	=> 'success'], 200);
		}
	}


	private function parse_store($id, $request)
	{
		// get data
		$input									= $request->only(
															'nama', 
															'template'
													);
		$input['judul']							= ($request->has('nama') && !is_null($request->input('nama'))) ? $request->input('nama') : 'Tidak ada judul [Untitled]';

		if(!is_null($id))
		{
			$input['id']						= $id;
		}

		$pattern		= "/\/t.*?<h.*?>(.*?)<\/h.*?>|\/t.*?<p.*?>(.*?)<\/p>|\/t.*?(<(ol|ul).*?><li>(.*?)<\/li>)|\/t.*?(<li>(.*?)<\/li><\/(ol|ul)>)|<h.*?>(.*?)<\/h.*?>|<p.*?>(.*?)<\/p>|(<(ol|ul).*?><li>(.*?)<\/li>)|(<li>(.*?)<\/li><\/(ol|ul)>)/i";

		preg_match_all($pattern, $input['template'], $out, PREG_PATTERN_ORDER);

		$input['paragraf']		= [];
		$input['mentionable']	= [];
		foreach ($out[0] as $key => $value) 
		{
			$value 								= str_replace('&nbsp;', ' ', $value);
			$input['paragraf'][$key]['konten']	= $value;
			$pattern_2 							= '/<span class="medium-editor-mention-at.*?>(.*?)<\/span>/i';

			if (preg_match_all($pattern_2, $value, $matches)) 
			{
				if (!isset($input['mentionable']))
				{
					if (is_array($matches[1]))
					{
						foreach ($matches[1] as $keyx => $valuex) 
						{
							if (str_is('@*', $valuex))
							{
								$input['mentionable'][]	= str_replace(',','',strip_tags($valuex));
							}
						}
					}
					else
					{
						if (str_is('@*', $valuex))
						{
							$input['mentionable'][]		= str_replace(',','',strip_tags($matches[1]));
						}
							
					}
				}
				elseif (!is_array($matches['1']) && !in_array($matches[1], $input['mentionable']))
				{
					$input['mentionable'][]				= str_replace(',','',strip_tags($matches[1]));
				}
				elseif (is_array($matches['1']))
				{
					$new_array 							= [];
					foreach ($matches[1] as $keyx => $valuex) 
					{
						if (str_is('@*', $valuex))
						{
							$new_array[]				= str_replace(',','',strip_tags($valuex));
						}
					}
					$input['mentionable']				= array_merge(
																array_intersect($input['mentionable'], $new_array),		//         2   4
																array_diff($input['mentionable'], $new_array),			//       1   3
																array_diff($new_array, $input['mentionable'])			//               5 6
															);															//  $u = 1 2 3 4 5 6
				}
			}
		}

		return $input;
	}

	/**
	 * function get list widgets on template create or edit
	 */
	private function list_widgets($template) 
	{
		$list           = TagService::fill_mention($template['dokumen_objek'], $template['dokumen_pihak'], $template['dokumen_saksi']);

		return $list;
	}

	/**
	 * function get list document pihak return json
	 */
	public function list_document()
	{
		$call 			= new DokumenWajibService;
		$dokumen_pihak	= $call::pihak();
		$dokumen_objek 	= $call::objek();
		$dokumen_saksi	= $call::saksi();
		
		return response()->json(['pihak' => $dokumen_pihak, 'objek' => $dokumen_objek, 'saksi' => $dokumen_saksi], 200);
	}

	public function initial()
	{
		$this->page_attributes->title       = 'Buat Template Dokumen Baru';

		$this->page_datas->id 				= null;
		// $this->page_datas->list_widgets     = $this->list_widgets();


		//initialize view
		$this->view                         = view('pages.akta.template.initial');

		//function from parent to generate view
		return $this->generateView();  
	}


	// Trash Bin
	public function trash()
	{
				// init
		$this->page_attributes->title       = 'Keranjang Sampah Template Akta';
		$this->page_attributes->hide['create']	= true;

		//filter&search
		$query                              = $this->getQueryString(['q','status', 'page']);
		$query['per_page']                  = (int)env('DATA_PERPAGE');

		// special treat judul
		if(isset($query['q'])){
			$query['judul']                 = $query['q'];
			unset($query['q']);     
		}

		// special treat sort
		if(isset($query['urutkan'])){
			try{
				$sort                       = explode("-", $query['urutkan']);
				$query['urutkan']           = [ $sort[0] => $sort[1]]; 
			} catch (Exception $e) {
				// display error?
			}
		}

		//get data from database
		$this->page_datas->datas            = $this->query->trash($query);

		//paginate
		$this->paginate(null, $this->query->countTrash($query), (int)env('DATA_PERPAGE'));        

		//initialize view
		$this->view                         = view('pages.akta.template.index');

		//function from parent to generate view
		return $this->generateView();  
	}
}
