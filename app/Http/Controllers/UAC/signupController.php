<?php

namespace App\Http\Controllers\UAC;

use TAuth, Redirect, Carbon\Carbon;

use App\Http\Controllers\Controller;

use App\Infrastructure\Traits\GuidTrait;
use App\Infrastructure\Traits\IDRTrait;

use App\Domain\Admin\Models\Kantor;
use App\Domain\Admin\Models\Pengguna;

use Illuminate\Http\Request;

class signupController extends Controller
{
	use GuidTrait;
	use IDRTrait;

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

	//fungsi signin
	public function trialEdit()
	{
		// init
		$kantor_id 	= TAuth::activeOffice()['kantor']['id'];
		$penggunas 	= Pengguna::kantor($kantor_id)->count();
		$total 		= $this->estimasiBiaya($penggunas);

		$this->page_attributes->title		= 'Upgrade Subscription Anda';
		$this->page_attributes->subtitle	= 'Upgrade ke paket starter akan dikenai '.$total.'/bulan/'.max(2, $penggunas).' akun.';

		//get data from database
		$this->page_datas->datas			= null;

		//initialize view
		$this->view							= view('market_web.pages.signup.edit');

		//function from parent to generate view
		return $this->generateView(); 
	}

	private function estimasiBiaya($total_user)
	{
		if($total_user <= 2)
		{
			return $this->formatMoneyTo(500000);
		}
		elseif ($total_user <= 5) 
		{
			$additional 	= $total_user - 2;
			$bayar 			= 500000 + ($additional * 225000);
			return $this->formatMoneyTo($bayar);
		}
		else 
		{
			$additional_1 	= $total_user - 5;

			$bayar 			= 500000 + (225000 * 3) + ($additional_1 * 200000);
			return $this->formatMoneyTo($bayar);
		}
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

			$pengguna->nama 		= $request->get('kantor')['nama'];
			$pengguna->alamat 		= $request->get('kantor')['alamat'];
			$pengguna->email 		= $credentials['email'];
			$pengguna->password 	= $credentials['password'];
			$pengguna->visas		= $credentials['visas'];

			$pengguna->save();

			$kantor 							= new Kantor;
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

	public function trialUpdate(Request $request)
	{
		$kantor_id 			= TAuth::activeOffice()['kantor']['id'];
		$penggunas 			= Pengguna::kantor($kantor_id)->get();

		foreach ($penggunas as $key => $value) 
		{
			$visa 				= $value->visas;
			$visa[0]['type']	= 'starter';
			$value->visas 		= $visa;
			$value->save();
		}

		return Redirect::route('uac.login.create');
	}
}
