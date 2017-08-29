<?php

namespace App\Http\Controllers\Administrative\UAC;

use TAuth, Redirect, Carbon\Carbon, Config, Exception, Session;

use App\Http\Controllers\Controller;

use App\Infrastructure\Traits\IDRTrait;
use App\Infrastructure\Traits\GuidTrait;
use App\Infrastructure\Traits\CountSubscriptionTrait;

use App\Domain\Administrative\Models\Kantor;
use App\Domain\Administrative\Models\Pengguna;

use Illuminate\Http\Request;

class signupController extends Controller
{
	use GuidTrait;
	use IDRTrait;
	use CountSubscriptionTrait;

	//fungsi signin
	public function create(Request $request)
	{
		// init
		$this->page_attributes->title		= 'Daftarkan Diri Anda';
		$this->page_attributes->subtitle	= 'Isi data diri Anda untuk mendapatkan akses penuh';

		//get data from database
		$this->page_datas->datas			= null;
		$this->page_datas->datas['plan']	= 'starter';

		//initialize view
		$this->view							= view('notaris.pages.administrative.uac.signup.create');

		//function from parent to generate view
		return $this->generateView(); 
	}

	//fungsi signin
	public function trialCreate()
	{
		// init
		$this->page_attributes->title		= 'Gratis '.Config::get('days_of_trial').' hari';
		$this->page_attributes->subtitle	= 'Isi data diri Anda untuk percobaan '.Config::get('days_of_trial').' hari';

		//get data from database
		$this->page_datas->datas			= null;
		$this->page_datas->datas['plan']	= 'trial';

		//initialize view
		$this->view							= view('notaris.pages.administrative.uac.signup.create');

		//function from parent to generate view
		return $this->generateView(); 
	}

	//fungsi signin
	public function trialEdit()
	{
		// init
		$kantor_id 	= TAuth::activeOffice()['kantor']['id'];
		$penggunas 	= Pengguna::kantor($kantor_id)->get();
		$total 		= $this->formatMoneyTo($this->hitungBiayaSubscribe($penggunas, Carbon::now()));

		$this->page_attributes->title		= 'Upgrade Subscription Anda';
		$this->page_attributes->subtitle	= 'Upgrade ke paket starter akan dikenai '.$total.'/bulan/'.max(2, $penggunas).' akun.';

		//get data from database
		$this->page_datas->datas			= null;

		//initialize view
		$this->view							= view('notaris.pages.administrative.uac.signup.edit');

		//function from parent to generate view
		return $this->generateView(); 
	}

	//fungsi simpan data karyawan
	public function store(Request $request, $expired = null, $paket = 'starter')
	{
		try {
			if(is_null($expired))
			{
				$expired 		= Carbon::now()->addmonths(1);
			}

			$kantor_id 			= self::createID('KANTORNOTARIS');

			$credentials['email']		= $request->get('akun')['email'];
			$credentials['password']	= $request->get('akun')['password'];

			//VALIDASI
			//A. Validasi
			//A1. Check unique email
			$email 				= Pengguna::email($credentials['email'])->first();
			if($email)
			{
				throw new Exception("Email Sudah Terdaftar", 1);
			}

			//A2. Check unique nomor pengangkatan
			$nomor_sk 			= Kantor::where('notaris.nomor_sk', $request->get('kantor')['nomor_sk'])->first();
			if($nomor_sk)
			{
				throw new Exception("Notaris dengan nomor sk yang sama sudah terdaftar dalam sistem", 1);
			}

			//PARSING
			//B1. Parsing Pengguna
			$visa['id']			= self::createID('IDNOTARIS');
			$visa['type']		= $paket;
			$visa['expired_at']	= $expired->format('Y-m-d H:i:s');
			$visa['started_at']	= Carbon::now()->format('Y-m-d H:i:s');
			$visa['role']		= 'notaris';
			$visa['kantor']		= ['id' => $kantor_id, 'nama' => $request->get('kantor')['nama']];

			if(str_is($visa['role'], 'drafter'))
			{
				$visa['scopes'] = env('DRAFTER_SCOPE', '');
			}
			elseif(str_is($visa['role'], 'manajer'))
			{
				$visa['scopes'] = env('MANAGER_SCOPE', '');
			}
			elseif(str_is($visa['role'], 'notaris'))
			{
				$visa['scopes'] = env('NOTARIS_SCOPE', '');
			}

			//B2. Parsing Kantor
			$dt_k['_id'] 						= $kantor_id;
			$dt_k['nama'] 						= $request->get('kantor')['nama'];
			$dt_k['notaris']['nama'] 			= $request->get('kantor')['nama'];
			$dt_k['notaris']['email'] 			= $credentials['email'];
			$dt_k['notaris']['nomor_sk'] 		= $request->get('kantor')['nomor_sk'];
			$dt_k['notaris']['tanggal_pengangkatan'] 	= Carbon::createFromFormat('d/m/Y', $request->get('kantor')['tanggal_pengangkatan'])->format('Y-m-d');
			$dt_k['notaris']['daerah_kerja'] 	= $request->get('kantor')['daerah_kerja'];
			$dt_k['notaris']['alamat'] 			= $request->get('kantor')['alamat'];
			$dt_k['notaris']['telepon'] 		= $request->get('kantor')['telepon'];
			$dt_k['notaris']['logo_url'] 		= '';

			//SIMPAN
			//C1. Simpan Pengguna
			$pengguna 			= new Pengguna;
			$pengguna->nama 	= $request->get('kantor')['nama'];
			$pengguna->alamat 	= $request->get('kantor')['alamat'];
			$pengguna->email 	= $credentials['email'];
			$pengguna->password = $credentials['password'];
			$pengguna->visas	= [$visa];

			$pengguna->save();

			//C2. Simpan Kantor
			$kantor 							= new Kantor;
			$kantor->fill($dt_k);
			$kantor->save();

			// event(new NotarisCreated($kantor));

			return Redirect::route('uac.login.create')->with('msg', ['success' => ['Profil Kantor Anda Berhasil dibuat!']]);
		}
		catch (Exception $e) {
			if(is_array($e->getMessage()))
			{
				return Redirect::back()->withErrors($e->getMessage());
			}
			else
			{
				return Redirect::back()->withErrors([$e->getMessage()]);
			}
		}
	}

	public function trialStore(Request $request)
	{
		$expired 	= Carbon::now()->addDays(Config::get('days_of_trial'));

		return $this->store($request, $expired, 'trial');
	}

	public function trialUpdate(Request $request)
	{
		try {
			$kantor_id 				= TAuth::activeOffice()['kantor']['id'];
			$penggunas 				= Pengguna::kantor($kantor_id)->get();

			foreach ($penggunas as $key => $value) 
			{
				$visa 				= $value->visas;
				$visa[0]['type']	= 'starter';
				$value->visas 		= $visa;
				$value->save();
			}

			return Redirect::route('uac.login.create')->with('msg', ['success' => ['Masa trial Anda berhasi di update!']]);
		} catch (Exception $e) {
			if(is_array($e->getMessage()))
			{
				return Redirect::back()->withErrors($e->getMessage());
			}
			else
			{
				return Redirect::back()->withErrors([$e->getMessage()]);
			}
		}
	}
}
