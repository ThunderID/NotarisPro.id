<?php

namespace App\Http\Controllers\Akta;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\Helpers\JSend;

use App\Service\Akta\DaftarTemplateAkta;

use App\Service\Akta\DaftarAkta as Query;
use App\Service\Akta\BuatAktaBaru;
use App\Service\Akta\SimpanAkta;
use App\Service\Akta\HapusAkta;

use App\Service\Akta\UnlockAkta;
use App\Service\Akta\PublishAkta;
use App\Service\Akta\FinalizeAkta;

use App\Service\Tag\TagService;
use App\Service\Admin\DaftarKantor;
use TAuth, App, PDF, Exception;

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
		$this->page_attributes->title		= 'Akta Dokumen';

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
		return $this->generateRedirect(route('akta.akta.create'));
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
			$input						= $request->only('klien', 'tanggal_pertemuan', 'judul', 'template', 'mentionable', 'template_id');
			$template					= new DaftarTemplateAkta;
			$template					= $template->detailed($input['template_id']);
	
			$input['klien']['id'] 		= (isset($input['klien']['id']) && !is_null($input['klien']['id'])) ? $input['klien']['id'] : null;
			$tanggal_pertemuan 			= date_create($input['tanggal_pertemuan']);
			$input['tanggal_pertemuan']	= date_format($tanggal_pertemuan, 'd/m/Y H:i');

			$akta						= new BuatAktaBaru($input['judul'], $template['paragraf'], 
														$input['mentionable'], $input['template_id']);

			$akta 						= $akta->save();
			//save tanggal pertemuan
		} catch (Exception $e) {
			$this->page_attributes->msg['error']	= $e->getMessage();
			return $this->generateRedirect(route('akta.akta.create'));
		}

		//return view
		$this->page_attributes->msg['success']		= ['Data akta telah ditambahkan'];

		return $this->generateRedirect(route('akta.akta.edit', $akta['id']));
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
		$this->page_datas->doc_inspector	= $this->doc_inspector($this->page_datas->datas);
		$this->page_datas->notaris			= $notaris;

		$data 								= collect($this->page_datas->datas['riwayat_status']);
		$this->page_datas->status_dalam_proses 	= $data->where('status', 'dalam_proses')->sortByDesc('tanggal')->toArray();
		$this->page_datas->status_draft 		= $data->where('status', 'draft')->sortByDesc('tanggal')->toArray();
		$this->page_datas->status_renvoi 		= $data->where('status', 'renvoi')->sortByDesc('tanggal')->toArray();
		$this->page_datas->status_akta 			= $data->where('status', 'akta')->sortByDesc('tanggal')->toArray();
		$this->page_datas->status_minuta 		= $data->where('status', 'minuta')->sortByDesc('tanggal')->toArray();

		$this->page_datas->template			= new DaftarTemplateAkta;
		$this->page_datas->template 		= $this->page_datas->template->thinning($this->page_datas->datas['template']['id']);

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
		$this->page_datas->datas			= $this->query->detailed($id);
		$this->page_datas->template_id 		= $this->page_datas->datas['template']['id'];

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
			$content 	= $this->parse_store($id, $request->only('template'));
			$akta		= new SimpanAkta($id, $request->get('judul'), $content['paragraf'], []);
			$akta		= $akta->save();
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
			$akta									= new HapusAkta($id);
			$akta									= $akta->save();
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
				case 'draft':
					$data		= new PublishAkta($id);
					break;
				case 'renvoi':
					$data		= new UnlockAkta($id, []);
					break;
				case 'akta':
					$data		= new FinalizeAkta($id, $request->get('nomor_akta'), $request->get('template'));
					break;
				default:
					throw new Exception("Status invalid", 1);
					break;
			}

			// save
			$data				= $data->save();

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
	public function choose_template(Request $request)
	{
		// init
		$this->page_attributes->title       = 'Pilih Template';

		if ($request->has('template_id'))
		{
			$this->page_datas->template_id	= $request->get('template_id');
		}
		else
		{
			$this->page_datas->template_id	= null;	
			
			$call 							= new DaftarTemplateAkta;
			$filter 						= ['status' => 'publish'];
			$list_template 					= $call->all($filter);

			//get data from database
			$this->page_datas->datas 		= $list_template;
		}

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
	 * function get list fillable mention on template
	 */
	public function list_widgets(Request $request) 
	{
		try 
		{
			$template_id 			= $request->get('template_id'); 

			$call					= new DaftarTemplateAkta;
			$template 				= $call->detailed($template_id);

			$mentionable			= [];

			if (isset($template['mentionable']))
			{
				foreach ($template['mentionable'] as $key => $value) 
				{
					if(!str_is('@notaris.*', $value) && !str_is('@akta.nomor', $value))
					{
						if(str_is('@objek*', $value))
						{
							$prefix 				= str_replace('@', '', $value);
							$prefix 				= explode('.', $prefix);
							$mentionable[$prefix[0]][$prefix[1]][]	= $value;
						}

						if(str_is('@saksi*', $value))
						{
							$prefix 				= str_replace('@', '', $value);
							$prefix 				= explode('.', $prefix);
							$mentionable[$prefix[0].'_'.$prefix[1]][$prefix[2]][]	= $value;
						}

						if(str_is('@pihak*', $value))
						{
							$prefix 				= str_replace('@', '', $value);
							$prefix 				= explode('.', $prefix);
							$mentionable[$prefix[0].'_'.$prefix[1]][$prefix[2]][]	= $value;
						}

						if(str_is('@akta*', $value))
						{
							$prefix 				= str_replace('@', '', $value);
							$prefix 				= explode('.', $prefix);
							$mentionable[$prefix[0]][$prefix[0]][]	= $value;
						}
					}
				}
			}

			return response()->json(['data' => $mentionable], 200);
			
		} catch (Exception $e) {
			$msg						= $e->getMessage();

			return response()->json(['data' => $msg], 200);
		}
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
		}
		elseif($check_status['status']=='dalam_proses')
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
		}
		else
		{
			throw new Exception("Status invalid", 1);
		}

		return $input;
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
			$check_status	= $this->query->detailed($akta_id);

			// get data
			$input			= $request->only('mention', 'isi_mention');
			$content 		= [$input['mention'] => $input['isi_mention']];

			// save
			// $this->parse_store($akta_id, $request->only('template'));
			$data 			= new SimpanAkta($akta_id, $check_status['judul'], $check_status['paragraf'], $content);
			$data 			= $data->save();
		} catch (Exception $e) {
			return JSend::error($e->getMessage())->asArray();
		}

		return JSend::success(['data' => $content])->asArray();
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
			$data			= new UnlockAkta($akta_id, [$input]);
			$data 			= $data->save();
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
		// get data akta
		$this->page_datas->datas			= $this->query->detailed($akta_id);

		//get data notaris
		$notaris 							= new DaftarKantor;
		$notaris 							= $notaris->detailed(TAuth::activeOffice()['kantor']['id']);
		$this->page_datas->notaris			= $notaris;

		//initialize view
		$this->view							= view('pages.akta.akta.pdf');

		// generate PDF
		set_time_limit(600); 
		return PDF::loadHTML($this->generateView())
			->setPaper('a4', 'portrait')
			->setOptions(['defaultFont' => 'courier'])
			->stream();
		
	}

	// Trash Bin
	public function trash()
	{
		// init
		$this->page_attributes->title       = 'Keranjang Sampah Akta Dokumen';
		$this->page_attributes->hide['create']	= true;


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

		//get data from database
		$this->page_datas->datas			= $this->query->trash($query);

		//paginate
		$this->paginate(null, $this->query->countTrash($query), (int)env('DATA_PERPAGE'));

		//initialize view
		$this->view							= view('pages.akta.akta.index');

		//function from parent to generate view
		return $this->generateView();  
	}

	private function doc_inspector(array $doc)
	{
		$required 	= [];
		foreach ($doc['mentionable'] as $key => $value) 
		{
			if(str_is('@pihak.*', $value))
			{
				$mention 		= str_replace('@', '', $value);
				$mentions 		= explode('.', $mention);
				$required['pihak'][$mentions[1]][$mentions[2]]			= false;

				foreach ($doc['fill_mention'] as $key2 => $value2)
				{
					if(str_is($key2, $value))
					{
						$required['pihak'][$mentions[1]][$mentions[2]]	= true;
					}
				} 
			}

			elseif(str_is('@saksi.*', $value))
			{
				$mention 		= str_replace('@', '', $value);
				$mentions 		= explode('.', $mention);
				$required['saksi'][$mentions[1]][$mentions[2]]			= false;

				foreach ($doc['fill_mention'] as $key2 => $value2)
				{
					if(str_is($key2, $value))
					{
						$required['saksi'][$mentions[1]][$mentions[2]]	= true;
					}
				} 
			}

			elseif(str_is('@objek.*', $value))
			{
				$mention 		= str_replace('@', '', $value);
				$mentions 		= explode('.', $mention);
				$required['objek'][$mentions[1]]			= false;

				foreach ($doc['fill_mention'] as $key2 => $value2)
				{
					if(str_is($key2, $value))
					{
						$required['objek'][0][$mentions[1]]	= true;
					}
				} 
			}
		}

		return $required;
	}
}
