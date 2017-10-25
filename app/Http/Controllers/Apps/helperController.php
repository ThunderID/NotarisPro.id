<?php
namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Thunderlabid\Akta\Models\Akta;

class helperController extends Controller {
	public static function aktaFilter ()
	{
		$jenis 				= Akta::distinct('jenis')->get();
		$filter['jenis']	= [];

		$filter['jenis']['akta_fidusia']	= 'Akta fidusia';
		$filter['jenis']['akta_jual_beli']	= 'Akta jual beli';
		$filter['jenis']['akta_pendirian']	= 'Akta pendirian';
		// foreach ($jenis as $key => $value) 
		// {
		// 	dd($value['attributes']);
		// 	foreach ($value as $k => $v) 
		// 	{
		// 		dd($k);
		// 		// $filter['jenis'][$v]	= $v;
		// 	}
		// }
		// 
		// $status 			= Akta::distinct('status')->get();

		// foreach ($status as $k => $v) 
		// {
		// 	foreach ($v['attributes'] as $k2 => $v2) {
		// 		dd($k2);
		// 	}
		// }

		return $filter;
	}

	public static function arsipList ()
	{

	}

}