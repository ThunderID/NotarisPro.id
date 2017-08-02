<?php

namespace App\Http\Controllers\UAC;

use TAuth, Redirect, Carbon\Carbon;

use App\Http\Controllers\Controller;

use App\Infrastructure\Traits\GuidTrait;

use App\Domain\Admin\Models\Kantor;
use App\Domain\Admin\Models\Pengguna;

use Illuminate\Http\Request;

class signupController extends Controller
{
	use GuidTrait;

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
		$this->view							= view('market_web.pages.signup.create');

		//function from parent to generate view
		return $this->generateView(); 
	}

	//fungsi signin
	public function trialCreate()
	{
		// init
		$this->page_attributes->title		= 'Gratis 14 hari';
		$this->page_attributes->subtitle	= 'Isi data diri Anda untuk percobaan 14 hari';

		//get data from database
		$this->page_datas->datas			= null;
		$this->page_datas->datas['plan']	= 'trial';

		//initialize view
		$this->view							= view('market_web.pages.signup.create');

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

			$visa['id']			= self::createID('IDNOTARIS');
			$visa['type']		= $paket;
			$visa['expired_at']	= $expired->format('Y-m-d H:i:s');
			$visa['started_at']	= Carbon::now()->format('Y-m-d H:i:s');
			$visa['role']		= 'admin';
			$visa['kantor']		= ['id' => $kantor_id, 'nama' => $request->get('kantor')['nama']];

			$pengguna 			= Pengguna::email($credentials['email'])->first();

			if($pengguna)
			{
				$credentials['visas']	= $pengguna['visas'];
				array_merge($credentials['visas'], [$visa]);
			}
			else
			{
				$pengguna 				= new Pengguna;
				$credentials['visas'][]	= $visa;
			}

			$pengguna->email 		= $credentials['email'];
			$pengguna->password 	= $credentials['password'];
			$pengguna->visas		= $credentials['visas'];

			$pengguna->save();

			$kantor 							= new Kantor;
			$dt_k['nama'] 						= $request->get('kantor')['nama'];
			$dt_k['notaris']['nama'] 			= $request->get('kantor')['nama'];
			$dt_k['notaris']['telepon'] 		= $request->get('kantor')['telepon'];
			$dt_k['notaris']['daerah_kerja'] 	= $request->get('kantor')['daerah_kerja'];
			$dt_k['notaris']['alamat'] 			= $request->get('kantor')['alamat'];
			$kantor->fill($dt_k);
			$kantor->save();

			return Redirect::route('uac.login.create')->with('pesan', 'Profil Kantor Anda Berhasil dibuat!');
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
		$expired 	= Carbon::now()->addDays(14);

		return $this->store($request, $expired, 'trial');
	}
}
