<?php

namespace App\Http\Controllers\Akta;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use TQueries\Helpers\JSend;

use TQueries\Akta\DaftarAkta as Query;
use TQueries\Akta\DaftarTemplateAkta;
use TQueries\Tags\TagService;
use TQueries\Kantor\DaftarNotaris;
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
	public function create(Request $request)
	{
		try {
			$template_id 			= $request->get('template_id'); 

			$call					= new DaftarTemplateAkta;
			$template 				= $call->detailed($template_id);

			// $akta['id']				= '';
			$akta['judul']			= $template['judul'];
			$akta['paragraf']		= $template['paragraf'];
			$akta['mentionable']	= $template['mentionable'];

			$notaris 				= new DaftarNotaris;
			$notaris 				= $notaris->detailed(TAuth::activeOffice()['kantor']['id']);

			foreach ($akta['mentionable'] as $key => $value) 
			{
				if(str_is($value, '@notaris.nama'))
				{
					$akta['fill_mention'][$value] 	= $notaris['notaris']['nama']; 
				}

				if(str_is($value, '@notaris.daerah_kerja'))
				{
					$akta['fill_mention'][$value] 	= $notaris['notaris']['daerah_kerja']; 
				}

				if(str_is($value, '@notaris.nomor_sk'))
				{
					$akta['fill_mention'][$value] 	= $notaris['notaris']['nomor_sk']; 
				}

				if(str_is($value, '@notaris.tanggal_pengangkatan'))
				{
					$akta['fill_mention'][$value] 	= $notaris['notaris']['tanggal_pengangkatan']; 
				}

				if(str_is($value, '@notaris.alamat'))
				{
					$akta['fill_mention'][$value] 	= $notaris['notaris']['alamat']; 
				}

				if(str_is($value, '@notaris.telepon'))
				{
					$akta['fill_mention'][$value] 	= $notaris['notaris']['telepon']; 
				}

				if(str_is($value, '@notaris.fax'))
				{
					$akta['fill_mention'][$value] 	= $notaris['notaris']['fax']; 
				}
			}

			// save
			$data			= new \TCommands\Akta\DraftingAkta($akta);
			$data 			= $data->handle();
		} catch (Exception $e) {
			$this->page_attributes->msg['error']	= $e->getMessage();
			return $this->generateRedirect(route('akta.akta.choose.template'));
		}

		$this->page_attributes->msg['success']         = ['Data akta telah di generate'];

		return $this->generateRedirect(route('akta.akta.edit', $data['id']));
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
			$input		= $request->only('template', 'template_id');
			$pattern 	= "/<h4.*?>(.*?)<\/h4>|<p.*?>(.*?)<\/p>|(<(ol|ul).*?><li>(.*?)<\/li>)|(<li>(.*?)<\/li><\/(ol|ul)>)/i";
			preg_match_all($pattern, $input['template'], $out, PREG_PATTERN_ORDER);
			// change key index like 'paragraph[*]'

			foreach ($out[0] as $key => $value) 
			{
				$input['paragraf'][$key]['konten']	= $value;
			}

			$call 									= new DaftarTemplateAkta;
			$template_id 							= $input['template_id'];
			$template								= $call->detailed($template_id);

			$input['mentionable']					= $template['mentionable'];
			$input['judul']							= $template['judul'];

			// save
			$data                               	= new \TCommands\Akta\DraftingAkta($input);
			$data->handle();
		} catch (Exception $e) {
			$this->page_attributes->msg['error']	= $e->getMessage();
		}

		//return view
		$this->page_attributes->msg['success']         = ['Data akta telah ditambahkan'];
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
		$this->page_datas->datas			= $this->query->detailed($id);
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
			$this->parse_store($id, $request);
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
	public function status($id, $status)
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
		$list_template 						= $call->get($filter);

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
		$versioning         				= new \TQueries\Akta\DaftarAkta;

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

	private function parse_store($id, $request)
	{
		// get data
		$input		= $request->only('template');
		$pattern 	= "/<h4.*?>(.*?)<\/h4>|<p.*?>(.*?)<\/p>|(<(ol|ul).*?><li>(.*?)<\/li>)|(<li>(.*?)<\/li><\/(ol|ul)>)/i";
		preg_match_all($pattern, $input['template'], $out, PREG_PATTERN_ORDER);
		// change key index like 'paragraph[*]'

		foreach ($out[0] as $key => $value) 
		{
			$input['paragraf'][$key]['konten']	= $value;
		}

		$check_status 							= $this->query->detailed($id);
		$input['id']							= $id;

		switch (strtolower($check_status['status'])) 
		{
			case 'draft':
				$data		= new \TCommands\Akta\DraftingAkta($input);
				$data 		= $data->handle();
				break;
			case 'renvoi':
				$data		= new \TCommands\Akta\SimpanAkta($input);
				$data 		= $data->handle();
				break;
			
			default:
				throw new Exception("Status invalid", 1);
				break;
		}

		return $data;
	}

	/**
	 * function automatic save
	 */
	public function automatic_store ($id = null, Request $request)
	{
		try {
			$this->parse_store($id, $request);
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
}
