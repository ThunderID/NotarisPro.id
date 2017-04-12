<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$this->call(InitAktaTableSeeder::class);
		$this->call(InitPengajuanAktaTableSeeder::class);
		$this->call(InitUpdateAktaTableSeeder::class);
		$this->call(InitRenvoiAktaTableSeeder::class);
		$this->call(InitKlienTableSeeder::class);
		// $this->call(TagihanTableSeeder::class);
		// $this->call(UsersTableSeeder::class);
	}
}
