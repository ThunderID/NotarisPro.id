<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class NotarisTest extends DuskTestCase
{
	/**
	 * A Dusk test example.
	 *
	 * @return void
	 */
	
	public function testExample ()
	{
		$this->browse(function ($browser)
		{
			$browser->visit('/login')
					->value('#email', 'admin@notaris.id')
					->value('#password', 'admin')
					->click('#btn-login');
			// $browser->visit('/akta/template/create')
			// 		->click('div.editor')
			// 		->pause(240000);
			// click search
				$browser->visit('/akta/template')
						->type('q', 'Akta Baru')
						->pause('2000')
						->keys('input.search', ['{enter}']);
			// click filter
				$browser->visit('/akta/template')
					->assertSee('Draft')
					->clickLink('Draft')
					->pause('1000')
					->assertSee('Publish')
					->clickLink('Publish')
					->pause('1000');
					// ->keys('input.search', ['{enter}']);
		});
	}

	// public function TestCreateTemplate ()
	// {
	// 	$this->browse(function ($browser)
	// 	{
	// 		$browser->visit('/akta/template/create')
	// 				->click('div.editor')
	// 				->value('div.editor', 'AKTA PENDIRIAN PERSEROAN TERBATAS @nama.perseroan_terbatas NOMOR @notaris.nomor_sk Pada hari ini @tanggal.menghadap, Hadir dihadapan saya, @notaris.nama Notaris di @notaris.alamat Dengan dihadiri oleh saksi-saksi yang saya, Notaris kenal dan akan disebut pada bagian akhir akta ini. Klien 1 Nama lengkap @klien.1.nama  Tempat tanggal lahir @klien.1.tempat_lahir Warga negara @klien.1.warga_negara Pekerjaan @klien.1.pekerjaan Tempat tinggal @klien.1.alamat Nomor KTP @klien.1.nomor_ktp ');
	// 	});
	// }
}