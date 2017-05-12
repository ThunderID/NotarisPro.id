<?php

namespace App\Http\Controllers\Akta;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use TQueries\Helpers\JSend;

use App\Service\Akta\DaftarAkta as Query;
use App\Service\Akta\DaftarTemplateAkta;
use TQueries\Tags\TagService;
use App\Service\Admin\DaftarKantor;
use TAuth;

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
		if(isset($query['q'])){
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
	public function create(Request $request)
	{
		//return view
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store($id = null, Request $request)
	{
		try 
		{
			$input				= $request->only('klien', 'tanggal_pertemuan', 'judul', 'template', 'mentionable', 'template_id');
			
			$call				= new DaftarTemplateAkta;
			$template			= $call->detailed($input['template_id']);

			//1. parse data 
			if(!isset($input['klien']['id']))
			{
				$save_klien 	= new SimpanKlien($input['klien']);
				$save_klien 	= $save_klien->handle();

				$input['klien']['id']				= $save_klien['id'];
			}

			$content['pemilik']['klien']['id']		= $input['klien']['id'];
			$content['pemilik']['klien']['nama'] 	= $input['klien']['nama'];
			$content['judul']						= $input['judul'];
			$content['tanggal_pertemuan']			= $input['tanggal_pertemuan'];
			$content['fill_mention']				= $input['mentionable'];
			$content['mentionable']					= $template['mentionable'];

			// get data
			$pattern 	= "/<h.*?>(.*?)<\/h.*?>|<p.*?>(.*?)<\/p>|(<(ol|ul).*?><li>(.*?)<\/li>)|(<li>(.*?)<\/li><\/(ol|ul)>)/i";
			preg_match_all($pattern, $input['template'], $out, PREG_PATTERN_ORDER);
			// change key index like 'paragraph[*]'

			foreach ($out[0] as $key => $value) 
			{
				$content['paragraf'][$key]['konten']	= preg_replace('/<br.*?><\/li>/i', '</li>', $out[0][$key]);
				$content['paragraf'][$key]['konten']	= preg_replace('/<br.*?><\/span>/i', '</span><br>', $out[0][$key]);
				$content['paragraf'][$key]['konten']	= preg_replace('/<br.*?><\/b>/i', '</b><br>', $out[0][$key]);
			}

			// save akta
			$data		= new \TCommands\Akta\DraftingAkta($input);
			$akta 		= $data->handle();

			//save tanggal pertemuan
		} catch (Exception $e) {
			$this->page_attributes->msg['error']	= $e->getMessage();
		}

		//return view
		$this->page_attributes->msg['success']		= ['Data akta telah ditambahkan'];
		return $this->generateRedirect(route('akta.akta.index'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//get data notaris
		$notaris 				= new DaftarKantor;
		$notaris 				= $notaris->detailed(TAuth::activeOffice()['kantor']['id']);

		$this->page_datas->datas			= $this->query->detailed($id);
		$this->page_datas->notaris			= $notaris;
		$this->page_attributes->title		= $this->page_datas->datas['judul'];

		//initialize view
		$this->view							= view('pages.akta.akta.show');

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
		// init
		$this->page_attributes->title       = 'Edit Akta';

		$this->page_datas->akta_id 			= $id;
		$this->page_datas->template_id 		= '';
		$this->page_datas->datas			= $this->query->detailed($id);

		//initialize view
		$this->view                         = view('pages.akta.akta.create');

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
	public function update(Request $request, $id)
	{
		//
		try {
			$this->parse_store($id, $request->only('template'));
		} catch (Exception $e) {
			$this->page_attributes->msg['error']	= $e->getMessage();
		}

		//return view
		if($id == null){
			$this->page_attributes->msg['success']         = ['Data akta telah ditambahkan'];
			return $this->generateRedirect(route('akta.akta.index'));
		}else{
			$this->page_attributes->msg['success']         = ['Data akta telah diperbarui'];
			return $this->generateRedirect(route('akta.akta.show', ['id' => $id]));
		}

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
			$akta									= new \TCommands\Akta\HapusAkta($id);
			$akta									= $akta->handle();
		} catch (Exception $e) {
			$this->page_attributes->msg['error']	= $e->getMesssage();
		}            

		$this->page_attributes->msg['success']		= ['Data akta telah dihapus'];

		//return view
		return $this->generateRedirect(route('akta.akta.index'));
	}

	/**
	 * update status akta
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function status(Request $request, $id, $status)
	{	
		try {
			switch (strtolower($status)) 
			{
				case 'pengajuan':
					$data		= new \TCommands\Akta\AjukanAkta($id);
					break;
				case 'renvoi':
					$data		= new \TCommands\Akta\RenvoiAkta($id);
					break;
				case 'akta':
					$data		= new \TCommands\Akta\FinalisasiAkta($id, $request->get('template'));
					break;
				default:
					throw new Exception("Status invalid", 1);
					break;
			}

			// save
			$data				= $data->handle();

		// save
		} catch (Exception $e) {
			$this->page_attributes->msg['error']	= $e->getMessage();
		}

		$this->page_attributes->msg['success']         = ['Data akta telah di simpan'];

		return $this->generateRedirect(route('akta.akta.show', $id));
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
		$list_template 						= $call->all($filter);

		//get data from database
		$this->page_datas->datas            = $list_template;

		//initialize view
		$this->view                         = view('pages.akta.akta.choosetemplate');

		//function from parent to generate view
		return $this->generateView();  
	}

	/**
	 * Function show versioning
	 */
	public function versioning($akta_id)
	{	
		$versioning         				= new \App\Service\Akta\DaftarAkta;

		$this->page_datas->datas			= $versioning->versioning($akta_id);
		$this->page_attributes->title		= 'Histori Revisi ' . $this->page_datas->datas['terbaru']['judul'];

		$this->page_datas->id				= $akta_id;


		//initialize view
		$this->view							= view('pages.akta.akta.versioning');

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

	private function parse_store($id, $template)
	{

		$check_status 								= $this->query->detailed($id);
		$input['id']								= $id;
		
		if(is_array($template['template']) && $check_status['status']=='renvoi')
		{
			$input['paragraf']						= $check_status['paragraf'];

			foreach ($template['template'] as $key => $value) 
			{
				$value 		= str_replace('&nbsp;', ' ', $value);
				$value		= preg_replace('/<br.*?><\/li>/i', '</li>', $value);
				$value		= preg_replace('/<br.*?><\/span>/i', '</span><br>', $value);
				$value		= preg_replace('/<br.*?><\/b>/i', '</b><br>', $value);

				$input['paragraf'][$key]['konten']	= $value;
			}

			$data			= new \TCommands\Akta\SimpanAkta($input);
			$data 			= $data->handle();
		}
		elseif($check_status['status']=='draft')
		{
			// get data
			$pattern		= "/\/t.*?<h.*?>(.*?)<\/h.*?>|\/t.*?<p.*?>(.*?)<\/p>|\/t.*?(<(ol|ul).*?><li>(.*?)<\/li>)|\/t.*?(<li>(.*?)<\/li><\/(ol|ul)>)|<h.*?>(.*?)<\/h.*?>|<p.*?>(.*?)<\/p>|(<(ol|ul).*?><li>(.*?)<\/li>)|(<li>(.*?)<\/li><\/(ol|ul)>)/i";
			
			preg_match_all($pattern, $template['template'], $out, PREG_PATTERN_ORDER);
			// change key index like 'paragraph[*]'

			foreach ($out[0] as $key => $value) 
			{
				$value		= preg_replace('/<br.*?><\/li>/i', '</li>', $value);
				$value		= preg_replace('/<br.*?><\/span>/i', '</span><br>', $value);
				$value		= preg_replace('/<br.*?><\/b>/i', '</b><br>', $value);

				$input['paragraf'][$key]['konten']	= $value;
			}

			$data			= new \TCommands\Akta\DraftingAkta($input);
			$data 			= $data->handle();
		}
		else
		{
			throw new Exception("Status invalid", 1);
		}

		return $data;
	}

	/**
	 * function automatic save
	 */
	public function automatic_store ($id = null, Request $request)
	{
		try {
			$this->parse_store($id, $request->only('template'));
		} catch (Exception $e) {
			return response()->json(['status'	=> $e->getMessage()], 200);
		}

		//return view
		$this->page_attributes->msg['success']         = ['Data template tersimpan'];
		return response()->json(['status'	=> 'success'], 200);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function mention($akta_id, Request $request)
	{
		 try {
			// get data
			$input			= $request->only('mention', 'isi_mention');
			$content 		= ['fill_mention' => [$input['mention'] => $input['isi_mention']]];
			$content['id']	= $akta_id;

			// save
			$data			= new \TCommands\Akta\DraftingAkta($content);
			$data 			= $data->handle();

			$this->parse_store($akta_id, $request->only('template'));
		} catch (Exception $e) {
			return JSend::error($e->getMessage())->asArray();
		}

		return JSend::success(['data' => $data['fill_mention']])->asArray();
	}


	/**
	 * menandai renvoi akta
	 *
	 */
	public function tandai_renvoi($akta_id, Request $request)
	{
		 try {
			// get data
			$input			= $request->get('lock');

			// save
			$data			= new \TCommands\Akta\TandaiRenvoi($akta_id, [$input]);
			$data 			= $data->handle();
		} catch (Exception $e) {
			return JSend::error($e->getMessage())->asArray();
		}

		return JSend::success(['data' => $input])->asArray();
	}

	/**
	 * Show the form for editing the specified resource with status renvoi.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function renvoi($id)
	{
		// init
		$this->page_attributes->title       = 'Edit Akta';

		$this->page_datas->akta_id 			= $id;
		$this->page_datas->template_id 		= '';
		$this->page_datas->datas			= $this->query->detailed($id);

		//initialize view
		$this->view                         = view('pages.akta.akta.renvoi');

		//function from parent to generate view
		return $this->generateView();  
	}

	public function pdf($akta_id)
	{
		$this->page_datas->datas			= $this->query->detailed($akta_id);
		$this->page_attributes->title		= $this->page_datas->datas['judul'];

		//initialize view
		$this->view							= view('pages.akta.akta.pdf');

		//function from parent to generate view
		return $this->generateView();
	}
}
