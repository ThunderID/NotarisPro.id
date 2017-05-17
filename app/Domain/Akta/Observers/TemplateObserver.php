<?php 

namespace App\Domain\Akta\Observers;

use App\Domain\Akta\Models\Template;
use Exception;

/**
 * Observer TemplateObserver
 *
 * Digunakan untuk Observe Model TemplateObserver in Link List Mode.
 *
 */
class TemplateObserver 
{
	/**
	* Menyimpan dokumen baru
	*
	* @param TemplateObserver $model
	* @return boolean
	*/
	public function saving($model)
	{
		//check
		$judul 			= Template::where('judul', $model->judul)->notid($model->_id)->kantor($model->pemilik['kantor']['id'])->first();

		if($judul)
		{
			throw new Exception('Duplikasi Judul', 1);

			return false;
		}

		return true;
	}
}