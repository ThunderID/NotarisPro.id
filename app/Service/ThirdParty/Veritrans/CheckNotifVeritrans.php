<?php

namespace App\Service\ThirdParty\Veritrans;

use App\Domain\Order\Models\HeaderTransaksi;

use Exception, TAuth, Carbon\Carbon;

class CheckNotifVeritrans
{
	/**
	 * Create new instance.
	 *
	 * @return CheckNotifVeritrans $akta
	 */
	// public function __construct()
	// {
	// }

	/**
	 * Simpan akta baru
	 *
	 * @return array $akta
	 */
	public function checker()
	{
			// Set our server key
			Veritrans_Config::$serverKey	= env('VERITRANS_SERVER_KEY', 'VT_KEY');
			// Uncomment for production environment
			Veritrans_Config::$isProduction	= env('VERITRANS_PRODUCTION', false);

			$trs 			= HeaderTransaksi::where('status', 'pending')->where('tipe', 'bukti_kas_keluar')->get();

			foreach ($trs as $key => $value) 
			{
				try {
					$notif		= new Veritrans_Notification(['transaction_id' => $value['nomor']]);

					if(str_is('settlement', $notif->transaction_status))
					{
						$value->status 	= 'lunas';
						$value->save();
					}
				} catch (Exception $e) {
					if($e->getCode()!=404)
					{
						throw $e;
					}				
				}
			}

		return true;
	}
}