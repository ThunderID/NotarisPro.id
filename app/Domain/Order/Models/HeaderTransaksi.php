<?php

namespace App\Domain\Order\Models;

use Illuminate\Database\Eloquent\Model;

use Validator, Exception;

/**
 * Model HeaderTransaksi
 *
 * @author     C Mooy <chelsy@thunderlab.id>
 */
class HeaderTransaksi extends Model
{
    protected $connection 			= 'mysql';

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table				= 'header_transaksi';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */

	protected $fillable				=	[
											'klien'					,
											'nomor'					,
											'status'				,
											'tipe'					,
											'tanggal_dikeluarkan'	,
											'tanggal_jatuh_tempo'	,
										];
	/**
	 * Basic rule of database
	 *
	 * @var array
	 */
	protected $rules				=	[
											'status'			=> 'in:pending,lunas',
										];
	/**
	 * Date will be returned as carbon
	 *
	 * @var array
	 */
	protected $dates				= ['created_at', 'updated_at', 'deleted_at', 'tanggal_dikeluarkan'];
	
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

	protected $appends 				= ['total'];

	/* ---------------------------------------------------------------------------- RELATIONSHIP ----------------------------------------------------------------------------*/
	public function details()
	{
		return $this->hasMany('App\Domain\Order\Models\DetailTransaksi', 'header_transaksi_id');
	}

	/* ---------------------------------------------------------------------------- QUERY BUILDER ----------------------------------------------------------------------------*/
	
	/* ---------------------------------------------------------------------------- MUTATOR ----------------------------------------------------------------------------*/

	/* ---------------------------------------------------------------------------- ACCESSOR ----------------------------------------------------------------------------*/
	public function getTotalAttribute()
	{
		$total 			= 0;
		foreach ((array)$this->details as $key => $value) 
		{
			$total 		= $total + ($value->kuantitas * ($value->harga_satuan - $value->diskon_satuan));
		}

		return $this->formatMoneyTo($total);
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

	public function scopeId($query, $value)
	{
		if(is_array($value))
		{
			return $query->whereIn('id', $value);
		}

		return $query->where('id', $value);
	}

	public function scopeKantor($query, $value)
	{
		if(is_array($value))
		{
			return $query->whereIn('kantor_id', $value);
		}

		return $query->where('kantor_id', $value);
	}
}
