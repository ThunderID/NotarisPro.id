<?php

namespace App\Service\Order;

use App\Domain\Order\Models\PurchaseOrder;

use Exception, DB, TAuth, Carbon\Carbon;

class TagihanBaru
{
	protected $nomor;
	protected $tanggal_dikeluarkan;
	protected $tanggal_jatuh_tempo;
	protected $details;
	protected $untuk;

	/**
	 * Create a new job instance.
	 *
	 * @param  $nomor
	 * @param  $tanggal_dikeluarkan
	 * @param  $tanggal_jatuh_tempo
	 * @param  $details
	 * @param  $oleh
	 * @param  $untuk
	 * @return void
	 */
	public function __construct($nomor, $tanggal_dikeluarkan, $tanggal_jatuh_tempo, array $details, array $untuk)
	{
		$this->nomor					= $nomor;
		$this->tanggal_dikeluarkan		= $tanggal_dikeluarkan;
		$this->tanggal_jatuh_tempo		= $tanggal_jatuh_tempo;
		$this->details					= $details;
		$this->untuk					= $untuk;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
	{
		try
		{
			$po 		= new Tagihan;

			//2. set ownership dokumen
			$tagihan['oleh']['id'] 			= TAuth::activeOffice()['kantor']['id'];
			$tagihan['oleh']['nama'] 		= TAuth::activeOffice()['kantor']['nama'];
			$tagihan['untuk']				= $this->untuk;
			$tagihan['nomor']				= $this->nomor;
			$tagihan['tanggal_dikeluarkan']	= $this->tanggal_dikeluarkan;
			$tagihan['tanggal_jatuh_tempo']	= $this->tanggal_jatuh_tempo;
			$tagihan['details']				= $this->details;

			//3. simpan value yang ada
			$po			= $po->fill($tagihan);

			//4. simpan tagihan
			$po->save();

			return $po->toArray();
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
}