<?php

namespace App\Domain\Order\Models;

use Illuminate\Database\Eloquent\Model;
use App\Infrastructure\Traits\IDRTrait;

use Validator, Exception;

/**
 * Model DetailTransaksi
 *
 * @author     C Mooy <chelsy@thunderlab.id>
 */
class DetailTransaksi extends Model
{
	use IDRTrait;

    protected $connection 			= 'mysql';

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table				= 'detail_transaksi';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */

	protected $fillable				=	[
											'header_transaksi_id'	,
											'referensi_id'			,
											'item'					,
											'deskripsi'				,
											'kuantitas'				,
											'harga_satuan'			,
											'diskon_satuan'			,
										];
	/**
	 * Basic rule of database
	 *
	 * @var array
	 */
	protected $rules				=	[
										
										];
	/**
	 * Date will be returned as carbon
	 *
	 * @var array
	 */
	protected $dates				= ['created_at', 'updated_at', 'deleted_at'];
	
	/**
	 * data hidden
	 *
	 * @var array
	 */
	protected $hidden				= 	[
											'created_at', 
											'updated_at', 
											'deleted_at', 
										];

	protected $appends 				= 	[
											'subtotal',
										];

	/* ---------------------------------------------------------------------------- RELATIONSHIP ----------------------------------------------------------------------------*/

	/* ---------------------------------------------------------------------------- QUERY BUILDER ----------------------------------------------------------------------------*/
	
	/* ---------------------------------------------------------------------------- MUTATOR ----------------------------------------------------------------------------*/

	/**
	 * formatting pengajuan kredit menjadi numeric dengan mata uang rupiah
	 *
	 * @param string $value ["Rp 200.000.000"]
	 */	
	protected function setHargaSatuanAttribute($value)
	{
		$this->attributes['harga_satuan']	= $this->formatMoneyFrom($value);
	}


	/**
	 * formatting pengajuan kredit menjadi numeric dengan mata uang rupiah
	 *
	 * @param string $value ["Rp 200.000.000"]
	 */	
	protected function setDiskonSatuanAttribute($value)
	{
		$this->attributes['diskon_satuan']	= $this->formatMoneyFrom($value);
	}

	/* ---------------------------------------------------------------------------- ACCESSOR ----------------------------------------------------------------------------*/

	/**
	 * formatting pengajuan kredit menjadi mata uang rupiah dari numeric
	 *
	 * @param numeric $value [200000000]
	 * @return string $value ["Rp 200.000.000"]
	 */	
	protected function getHargaSatuanAttribute($value)
	{
		return $this->formatMoneyTo($value);
	}

	/**
	 */	
	protected function getSubtotalAttribute($value)
	{
		return $this->formatMoneyTo(($this->formatMoneyFrom($this->harga_satuan) - $this->formatMoneyFrom($this->diskon_satuan)) * $this->kuantitas);
	}

	/**
	 * formatting pengajuan kredit menjadi mata uang rupiah dari numeric
	 *
	 * @param numeric $value [200000000]
	 * @return string $value ["Rp 200.000.000"]
	 */	
	protected function getDiskonSatuanAttribute($value)
	{
		return $this->formatMoneyTo($value);
	}


	/* ---------------------------------------------------------------------------- FUNCTIONS ----------------------------------------------------------------------------*/

	/**
	 * boot
	 * observing model
	 *
	 */	
	public static function boot() 
	{
		parent::boot();
	}

	/* ---------------------------------------------------------------------------- SCOPES ----------------------------------------------------------------------------*/
}
