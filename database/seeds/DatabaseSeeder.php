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
		$this->call(InitNotarisTableSeeder::class);
		// $this->call(InitTemplateTableSeeder::class);
		// $this->call(InitKlienTableSeeder::class);
		// $this->call(InitAktaTableSeeder::class);
		// $this->call(InitJadwalTableSeeder::class);
		// $this->call(InitTagihanTableSeeder::class);
		// $this->call(IndonesiaTableSeeder::class);
		// $this->call(UsersTableSeeder::class);
	}
}
