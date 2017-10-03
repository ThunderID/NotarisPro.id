<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Thunderlabid\Manajemen\Models\User;

class ManajemenTableSeeder extends Seeder
{
	public function run()
	{
		DB::collection('m_kantor')->truncate();
		DB::collection('m_user')->truncate();

		User::create([
			'nama'   => 'Anna Wong, Sarjana Hukum', 
			'email' => 'anna.wong@thunderlab.id', 
			'password' => 'adminadmin', 
			'access' => [
				'kantor' => ['id' => null, 'nama' => 'Kantor Notaris & PPAT Anna Wong, Sarjana Hukum'],
				'role'	=> 'notaris',
				'scopes' => env('SU_SCOPES', 'kantor,user,drafting,renvoi')]
		]);

	}
}
