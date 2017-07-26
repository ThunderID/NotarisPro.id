<?php

namespace App\Http\Controllers\POS;

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

class bkkPOSController extends Controller
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
		$this->page_attributes->title		= 'Bukti Kas Keluar';

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
		$this->view							= view('pages.pos.bkk.index');

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
}
