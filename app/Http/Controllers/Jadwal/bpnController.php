<?php

namespace App\Http\Controllers\Jadwal;

use Illuminate\Http\Request;
use App\Domain\Order\Models\Jadwal as Query;
use App\Domain\Akta\Models\Dokumen;

use App\Http\Controllers\Controller;

use App\Infrastructure\Traits\GuidTrait;

use TAuth, Exception, Carbon\Carbon;

class bpnController extends Controller
{
	use GuidTrait;

	public function __construct(Query $query)
	{
		parent::__construct();
		
		$this->query			= $query;
		$this->per_page 		= (int)env('DATA_PERPAGE');
	}    

	public function index(Request $request)
	{
		//0. set active office
		$this->active_office                = TAuth::activeOffice();

		// 1. set page attributes
		$this->page_attributes->title       = 'Jadwal Monitoring BPN';

		// 2. call all tagihans data needed
		//2a. parse query searching
		$query                              = $request->only('cari', 'filter', 'urutkan', 'page');

		//2b. retrieve all bpn
		$this->retrieveBpn($query);

		//2c. get all filter 
		$this->page_datas->filters          = $this->retrieveBpnFilter();
		
		//2d. get all urutan 
		$this->page_datas->urutkan          = $this->retrieveBpnUrutkan();

		//3.initialize view
		$this->view                         = view('notaris.pages.jadwal.bpn.index');

		return $this->generateView();
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show(Request $request, $id)
	{
		$this->active_office 				= TAuth::activeOffice();

		// 1. set page attributes
		$this->page_attributes->title       = 'Jadwal Monitoring BPN';

		// 2. call all tagihans data needed
		//2a. parse query searching
		$query 								= $request->only('cari', 'filter', 'urutkan', 'page');

		//2b. retrieve all bpn
		$this->retrieveBpn($query);

		//2c. get all filter 
		$this->page_datas->filters 			= $this->retrieveBpnFilter();
		
		//2d. get all urutan 
		$this->page_datas->urutkan 			= $this->retrieveBpnUrutkan();

		//2e. get show document
		$this->page_datas->jadwal 			= $this->query->id($id)->kantor($this->active_office['kantor']['id'])->first();

		//3.initialize view
		$this->view                         = view('notaris.pages.jadwal.bpn.show');
		
		return $this->generateView();  
	}

	private function test()
	{
		// $client = new \Google_Client();

// $credentialsJson should contain the path to the json file downloaded from the API site
		// $credentialJson 	= '{"web":{"client_id":"323258491938-q5jrf77d15d8j9cfpuksl3b4hcnajrru.apps.googleusercontent.com","project_id":"mitra-notaris","auth_uri":"https://accounts.google.com/o/oauth2/auth","token_uri":"https://accounts.google.com/o/oauth2/token","auth_provider_x509_cert_url":"https://www.googleapis.com/oauth2/v1/certs","client_secret":"96cE1nz0lRVWTHExmqrILh4R"}}';

		$client = new \Google_Client;

		$client->setApplicationName("Mitra Notaris");
		$client->setDeveloperKey("AIzaSyCuY5OpGqq9639C45rlSsm460gPae9BtWk");


		$calendarId 	= 'a19g6utd9dkq9b5prseoj7779o@group.calendar.google.com';
// $credentials = $client->loadServiceAccountJson(
//    $credentialJson,
//    'https://www.googleapis.com/auth/calendar'
// );

// $client->setAssertionCredentials($credentials);

$service = new \Google_Service_Calendar($client);
dd($service);
// $calendarId should contain the calendar id found on the settings page of the calendar
$events = $service->events->listEvents($calendarId);

dd($events);
	}

	public function create(Request $request, $id = null)
	{
		//set this function
		$this->active_office 			= TAuth::activeOffice();

		//1. set page attributes
		$this->page_attributes->title	= 'bpn';

		//2. get show document
		$this->page_datas->bpn 			= $this->query->id($id)->kantor($this->active_office['kantor']['id'])->first();

		$this->view						= view('pages.jadwal.bpn.create');
		
		return $this->generateView();  
	}

	public function store(Request $request, $id = null)
	{
		try {
			//set this function
			$this->active_office	= TAuth::activeOffice();

			//2. get store document
			$bpn				= $this->query->id($id)->kantor($this->active_office['kantor']['id'])->first();
			
			if(!$bpn)
			{
				$bpn 			= new $this->query;
			}

			$akta 				= Dokumen::where('nomor_akta', $request->get('nomor_akta'))->kantor($this->active_office['kantor']['id'])->first();

			$bpn->title 		= $akta['judul'];
			$bpn->start 		= $request->get('tanggal_mulai');
			$bpn->end 			= $request->get('tanggal_selesai');
			$bpn->referensi 	= ['id' => $akta['id'], 'nomor_akta' => $request->get('nomor_akta')];

			$bpn->pembuat 		= ['kantor' => $this->active_office['kantor']];
			$bpn->save();

			$this->page_attributes->msg['success']		= ['BPN Berhasil Disimpan'];
	
			return $this->generateRedirect(route('jadwal.bpn.show', $bpn->id));
		} catch (Exception $e) {
			$this->page_attributes->msg['error']		= $e->getMessage();
	
			return $this->generateRedirect(route('jadwal.bpn.index', ['id' => $id]));
		}
	}

	public function edit(Request $request, $id)
	{
		return $this->create($request, $id);
	}

	public function update(Request $request, $id)
	{
		return $this->store($request, $id);
	}

	public function destroy(Request $request, $id)
	{
		try {
			//set this function
			$this->active_office	= TAuth::activeOffice();

			//2. get store document
			$bpn					= $this->query->id($id)->kantor($this->active_office['kantor']['id'])->firstorfail();
			$bpn->delete();

			$this->page_attributes->msg['success']		= ['Jadwal Berhasil Dihapus'];
	
			return $this->generateRedirect(route('jadwal.bpn.index'));
		} catch (Exception $e) {
			$this->page_attributes->msg['error']		= $e->getMessage();
	
			return $this->generateRedirect(route('jadwal.bpn.show', ['id' => $id]));
		}	
	}

	private function retrieveBpn($query = [])
	{
		//1. pastikan berasal dari kantor yang sama
		$data		= $this->query->kantor($this->active_office['kantor']['id']);

		//2. cari sesuai query
		if(isset($query['cari']))
		{
			$data			= $data->where(function($q)use($query){$q->where('title', 'like', '%'.$query['cari'].'%');});
		}

		//3. urutkan
		if(isset($query['urutkan']))
		{
			$explode        = explode('-', $query['urutkan']);
			if(in_array($explode[0], ['nama']) && in_array($explode[1], ['asc', 'desc']))
			{
				$data       = $data->orderby('title', $value)->orderby('ktp.nama', $value);
			}
		}

		//4. page
		$skip				= 0;
		if(isset($query['page']))
		{
			$skip			= ((1 * $query['page']) - 1) * $this->per_page;
		}
		//set datas
		$this->paginate(null, $data->count(), $this->per_page);
		$this->page_datas->bpns	= $data->skip($skip)->take($this->per_page)->get(['_id', 'title', 'start', 'end'])->toArray();
	}

	private function retrieveBpnFilter()
	{
		return $filter = [];
	}
	
	private function retrieveBpnUrutkan()
	{
		//1a.cari urutan
		$sort   =   [
					];

		return $sort;
	}

}
