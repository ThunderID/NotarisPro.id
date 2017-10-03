<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Thunderlabid\Akta\Models\Akta;
use Thunderlabid\Arsip\Models\Arsip;
use Thunderlabid\Manajemen\Models\User;

class DraftingTableSeeder extends Seeder
{
	public function run()
	{
		DB::collection('a_akta')->truncate();

		$user 	= User::first();
		$isi_akta['status']	= 'drafting';
		$isi_akta['versi']	= 1;
		$isi_akta['drafter']= ['email' => $user['email'], 'nama' => $user['nama']];
		$isi_akta['kantor'] = ['id' => $user['access']['kantor']['id'], 'nama' => $user['access']['kantor']['nama']];
		$isi_akta['judul']  = 'AKTA JUAL BELI RUMAH DI MENGWI';
		$isi_akta['jenis']	= 'AJB';

		$client_1 	= Arsip::where('dokumen.nama', 'John Doe')->first();
		$client_2 	= Arsip::where('dokumen.nama', 'Jane Doe')->first();
		$saksi_1 	= Arsip::where('dokumen.nama', 'Christian Doe')->first();
		$saksi_2 	= Arsip::where('dokumen.nama', 'Christine Doe')->first();

		$isi_akta['paragraf']	= '<h4>AKTA JUAL BELI</h4>
		<h6>Nomor : <span class="text-mention" data-mention="@akta.nomor@">112/2013</span></h6>
		<br/>
		<p><i>Lembar Pertama</i></p>
		<br/>
		<p>Pada hari ini, <span class="text-mention" data-mention="@akta.hari@">Selasa</span>, tanggal <span class="text-mention" data-mention="@akta.tanggal@">03 (tiga) Bulan 12 (Desember) tahun 2013 (dua ribu tiga belas)</span>. Hadir dihadapan saya, <span class="text-mention" data-mention="@notaris.nama@">'.$user['nama'].'</span> yang berdasarkan Surat Keputusan Kepala Badan Pertanahan Nasional tanggal ... nomor ... diangkat sebagai Pejabat Pembuat Akta Tanah yang selanjutnya disebut PPAT, yang dimaksud dalam pasal 7 Peraturan Pemerintah Nomor 24 Tahun 1997 tentang Pendaftaran Tanah, dengan daerah kerja Kota Administrasi Jakarta Selatan, dan berkantor di ..., dengan dihadiri oleh saksi-saksi yang saya kenal dan akan disebut pada bagian akhir akta ini :</p>
		<ol style="I"><li>Nama	: <span class="text-mention" data-mention="@'.$client_1['dokumen'][0]['id'].'.ktp.nama@">'.$client_1['dokumen'][0]['nama'].'</span><br/>Tempat Lahir : <span class="text-mention" data-mention="@'.$client_1['dokumen'][0]['id'].'.ktp.tempat_lahir@">'.$client_1['dokumen'][0]['tempat_lahir'].'</span><br/>Tanggal Lahir : <span class="text-mention" data-mention="@'.$client_1['dokumen'][0]['id'].'.ktp.tanggal_lahir@">'.$client_1['dokumen'][0]['tanggal_lahir'].'</span><br/>Pekerjaan : <span class="text-mention" data-mention="@'.$client_1['dokumen'][0]['id'].'.ktp.pekerjaan@">'.$client_1['dokumen'][0]['pekerjaan'].'</span><br/>Alamat : <span class="text-mention" data-mention="@'.$client_1['dokumen'][0]['id'].'.ktp.alamat@">'.$client_1['dokumen'][0]['alamat'].'</span><br/>selaku PENJUAL, untuk selanjutnya disebut PIHAK PERTAMA.</li><li>Nama	: <span class="text-mention" data-mention="@'.$client_2['dokumen'][0]['id'].'.ktp.nama@">'.$client_2['dokumen'][0]['nama'].'</span><br/>Tempat Lahir : <span class="text-mention" data-mention="@'.$client_2['dokumen'][0]['id'].'.ktp.tempat_lahir@">'.$client_2['dokumen'][0]['tempat_lahir'].'</span><br/>Tanggal Lahir : <span class="text-mention" data-mention="@'.$client_2['dokumen'][0]['id'].'.ktp.tanggal_lahir@">'.$client_2['dokumen'][0]['tanggal_lahir'].'</span><br/>Pekerjaan : <span class="text-mention" data-mention="@'.$client_2['dokumen'][0]['id'].'.ktp.pekerjaan@">'.$client_2['dokumen'][0]['pekerjaan'].'</span><br/>Alamat : <span class="text-mention" data-mention="@'.$client_2['dokumen'][0]['id'].'.ktp.alamat@">'.$client_2['dokumen'][0]['alamat'].'</span><br/>selaku PEMBELI, untuk selanjutnya disebut PIHAK KEDUA.</li></ol>
		<p>Para penghadap dikenal oleh Saya, PPAT.</p>
		<p>Pihak Pertama menerangkan dengan ini menjual kepada Pihak Kedua dan Pihak Kedua menerangkan dengan ini membeli dari Pihak Pertama : </p>
		<ul><li>Hak Milik atas sebidang tanah nomor <span class="text-mention" data-mention="@'.$client_1['dokumen'][1]['id'].'.sertifikat.nomor@">'.$client_1['dokumen'][1]['nomor'].'</span>/ Desa <span class="text-mention" data-mention="@'.$client_1['dokumen'][1]['id'].'.sertifikat.alamat.kelurahan@">'.$client_1['dokumen'][1]['alamat']['kelurahan'].'</span>, Gambar situasi tanggal <span class="text-mention" data-mention="@'.$client_1['dokumen'][1]['id'].'.sertifikat.tanggal@">'.$client_1['dokumen'][1]['tanggal'].'</span>, nomor <span class="text-mention" data-mention="@'.$client_1['dokumen'][1]['id'].'.sertifikat.nomor_gambar@">'.$client_1['dokumen'][1]['nomor_gambar'].'</span>, seluas <span class="text-mention" data-mention="@'.$client_1['dokumen'][1]['id'].'.sertifikat.luas@">'.$client_1['dokumen'][1]['luas'].'</span> dengan nomor identifikasi bidang tanah (NIB) <span class="text-mention" data-mention="@'.$client_1['dokumen'][1]['id'].'.sertifikat.nib@">'.$client_1['dokumen'][1]['nib'].'</span>, dan Surat Pemberitahuan Pajak Terhutang Pajak Bumi dan Bangunan (SPPT PBB) nomor objek pajak (NOP) <span class="text-mention" data-mention="@'.$client_1['dokumen'][1]['id'].'.sertifikat.nop@">'.$client_1['dokumen'][1]['nop'].'</span> terletak di<ul><li>Provinsi : <span class="text-mention" data-mention="@'.$client_1['dokumen'][1]['id'].'.sertifikat.alamat.provinsi@">'.$client_1['dokumen'][1]['alamat']['provinsi'].'</span></li><li>Kabupaten : <span class="text-mention" data-mention="@'.$client_1['dokumen'][1]['id'].'.sertifikat.alamat.kabupaten@">'.$client_1['dokumen'][1]['alamat']['kabupaten'].'</span></li><li>Kecamatan : <span class="text-mention" data-mention="@'.$client_1['dokumen'][1]['id'].'.sertifikat.alamat.kecamatan@">'.$client_1['dokumen'][1]['alamat']['kecamatan'].'</span></li><li>Kelurahan : <span class="text-mention" data-mention="@'.$client_1['dokumen'][1]['id'].'.sertifikat.alamat.kelurahan@">'.$client_1['dokumen'][1]['alamat']['kelurahan'].'</span></li><li>Jalan : <span class="text-mention" data-mention="@'.$client_1['dokumen'][1]['id'].'.sertifikat.alamat.jalan@">'.$client_1['dokumen'][1]['alamat']['jalan'].'</span></li></ul></li></ul>
		<p>Jual Beli ini meliputi pula</p>
		<p>Segala sesuatu yang berdiri dan/atau tertanam diatas tanah tersebut yang menurut sifat/peruntukkannya serta menurut ketentuan Undang Undang dianggap sebagai benda tetap/tidak bergerak terutama bangunan rumah tempat tinggal yang berdiri ditas tanah tersebut berikut turutan-turutannya,</p>
		<p>Selanjutnya semua yang diuraikan diatas dalam akta ini</p>
		<p>disebut sebagai "OBJEK JUAL BELI"</p><br/>
		<p>Pihak Pertama dan Pihak Kedua menerangkan bahwa:</p>
		<ol style="a"><li>Jual beli ini dilakukan dengan harga <span class="text-mention" data-mention="@'.$client_1['dokumen'][1]['id'].'.sertifikat.harga_jual@">'.$client_1['dokumen'][1]['harga_jual'].'</span>.</li><li>Pihak Pertama mengaku telah menerima sepenuhnya uang tersebut diatas dari Pihak Kedua dan untuk penerimaan uang tersebut akta ini berlaku pula sebagai tanda penerimaan yang sah (kuitansi).</li><li>Jual beli ini dilakukan dengan syarat-syarat sebagai berikut:<p>Pasal 1</p><p>Mulai hari ini obyek jual beli yang diuraikan dalam akta ini telah menjadi milik Pihak Kedua dan karenanya segala keuntungan yang didapat dari, dan segala kerugian/beban atas obyek jual beli tersebut di atas menjadi hak/beban Pihak Kedua.</p><p>Pasal 2</p><p>Pihak Pertama menjamin, bahwa obyek jual beli tersebut di atas tidak tersangkut dalam suatu sengketa, bebas dari sitaan, tidak terikat sebagai jaminan untuk sesuatu utang yang tidak tercatat dalam sertipikat, dan bebas dari beban-beban lainnya yang berupa apapun.</p><p>Pasal 3</p><p>Pihak Kedua dengan ini menyatakan bahwa dengan jual beli ini kepemilikan tanahnya tidak melebihi ketentuan maksimum penguasaan tanah menurut ketentuan perundang-undangan yang berlaku.</p><p>Pasal 4</p><p>Dalam hal terdapat perbedaan luas tanah yang menjadi obyek jual beli dalam akta ini dengan hasil pengukuran oleh instansi Badan Pertanahan Nasional, maka para pihak akan menerima hasil pengukuran instansi Badan Pertanahan Nasional tersebut dengan tidak memperhitungkan kembali harga jual beli dan tidak akan saling mengadakan gugatan.</p><p>Pasal 5</p><p>Pihak Pertama dan Pihak Kedua telah sama-sama mengetahui benar tentang lokasi, keadaan fisik, serta peruntukan tanah yang menjadi obyek Jual Beli dalam akta ini serta membebaskan Pejabat Pembuat Akta Tanah dan para saksi dari segala tuntutan atau gugatan berupa apapun.</p><p>Pasal 6</p><p>Pihak Pertama dan Pihak Kedua dalam hal ini menyatakan bahwa identitas Pihak Pertama dan Pihak Kedua adalah benar adanya, sama dengan data-data yang diberikan dan diperlihatkan kepada saya, Pejabat Pembuat Akta Tanah, dan apabila di kemudian hari ternyata identitas tersebut tidak benar danada tuntutan hukum, dengan ini dibebaskan dari segala tuntutan dan sepenuhnya menjadi kewajiban atau tanggung jawab Pihak Pertama dan Pihak Kedua.</p><p>Pasal 7</p><p>Kedua belah pihak dalam hal ini dengan segala akibatnya memilih tempat kediaman hukum yang umum dan tidak berubah pada Kantor Panitera Pengadilan Negeri <span class="text-mention" data-mention="@akta.pn@">Bali</span></p><p>Pasal 8</p><p>Biaya pembuatan akta ini, uang saksi dan segala biaya peralihan hak ini dibayar oleh PIHAK PERTAMA</p></li></ol>
		<p>Demikianlah akta ini dibuat dihadapan para pihak dan :</p>
		<ol><li>Tuan <span class="text-mention" data-mention="@'.$saksi_1['dokumen'][0]['id'].'.ktp.nama@">'.$saksi_1['dokumen'][0]['nama'].'</span>, Warga Negara <span class="text-mention" data-mention="@'.$saksi_1['dokumen'][0]['id'].'.ktp.kewarganegaraan@">'.$saksi_1['dokumen'][0]['kewarganegaraan'].'</span>, Karyawan Pejabat Pembuat Akta Tanah.</li><li>Nona <span class="text-mention" data-mention="@'.$saksi_2['dokumen'][0]['id'].'.ktp.nama@">'.$saksi_2['dokumen'][0]['nama'].'</span>, Warga Negara <span class="text-mention" data-mention="@'.$saksi_2['dokumen'][0]['id'].'.ktp.kewarganegaraan@">'.$saksi_2['dokumen'][0]['kewarganegaraan'].'</span>, Karyawati Pejabat Pembuat Akta Tanah.</li></ol>
		<p>sebagai saksi-saksi, dan setelah dibacakan serta dijelaskan, maka sebagai bukti kebenaran pernyataan yang dikemukakan oleh Pihak Pertama dan Pihak Kedua tersebut di atas, akta ini ditandatangani/cap ibu jari oleh Pihak Pertama, Pihak Kedua, para saksi dan Saya, PPAT, sebanyak 2 (dua) rangkap asli, yaitu 1 (satu) rangkap lembar pertama disimpan di kantor Saya, dan 1 (satu) rangkap lembar kedua disampaikan kepada Kepala Kantor Pertanahan Kota Administrasi Jakarta Selatan untuk keperluan pendaftaran peralihan hak akibat jual beli dalam akta ini. </p>
		<br/>
		<br/>
		<br/>
		<br/>
		<p>&emsp;&emsp;&emsp;PIHAK PERTAMA&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;PIHAK KEDUA&emsp;&emsp;&emsp;</p>
		<br/>
		<br/>
		<br/>
		<br/>
		<p>&emsp;&emsp;&emsp;<span class="text-mention" data-mention="@'.$client_1['dokumen'][0]['id'].'.ktp.nama@">John Doe</span>
		&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<span class="text-mention" data-mention="@'.$client_2['dokumen'][0]['id'].'.ktp.nama@">Jane Doe</span>&emsp;&emsp;&emsp;</p>
		<p>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;PERSETUJUAN&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</p>
		<p>&emsp;&emsp;&emsp;SAKSI PERTAMA&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;SAKSI KEDUA&emsp;&emsp;&emsp;</p>
		<br/>
		<br/>
		<br/>
		<br/>
		<p>&emsp;&emsp;&emsp;<span class="text-mention" data-mention="@'.$saksi_1['dokumen'][0]['id'].'.ktp.nama@">'.$saksi_1['dokumen'][0]['nama'].'</span>
		&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<span class="text-mention" data-mention="@'.$saksi_2['dokumen'][0]['id'].'.ktp.nama@">'.$saksi_2['dokumen'][0]['nama'].'</span>&emsp;&emsp;&emsp;</p>
		<p>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Pejabat Pembuat Akta Tanah&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</p>
		<p>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<span class="text-mention" data-mention="@notaris.nama@">'.$user['nama'].'</span>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</p>';
		Akta::create($isi_akta);
	}
}
