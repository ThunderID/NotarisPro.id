<?php

namespace App\Domain\Order\Models;

use Illuminate\Database\Eloquent\Model;
use App\Infrastructure\Traits\IDRTrait;
use App\Infrastructure\Traits\TanggalSQLTrait;

use Validator, Exception;

/**
 * Model HeaderTransaksi
 *
 * @author     C Mooy <chelsy@thunderlab.id>
 */
class HeaderTransaksi extends Model
{
	use TanggalSQLTrait;
	use IDRTrait;
	
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
											'kantor_id'				,
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

	protected $appends 				= ['total'];

	/* ---------------------------------------------------------------------------- RELATIONSHIP ----------------------------------------------------------------------------*/
	public function details()
	{
		return $this->hasMany('App\Domain\Order\Models\DetailTransaksi', 'header_transaksi_id');
	}

	/* ---------------------------------------------------------------------------- QUERY BUILDER ----------------------------------------------------------------------------*/
	
	/* ---------------------------------------------------------------------------- MUTATOR ----------------------------------------------------------------------------*/
	/**
	 *
	 */	
	protected function setKlienAttribute($value)
	{
		$this->attributes['klien']					= json_encode($value);
	}

	/**
	 *
	 */	
	protected function setTanggalDikeluarkanAttribute($value)
	{
		$this->attributes['tanggal_dikeluarkan']	= $this->formatDateFrom($value);
	}

	/**
	 *
	 */	
	protected function setTanggalJatuhTempoAttribute($value)
	{
		$this->attributes['tanggal_jatuh_tempo']	= $this->formatDateFrom($value);
	}

	/* ---------------------------------------------------------------------------- ACCESSOR ----------------------------------------------------------------------------*/
	public function getTotalAttribute()
	{

		$total 			= 0;
		foreach ($this->details as $key => $value) 
		{
			$total 		= $total + ($value->kuantitas * ($this->formatMoneyFrom($value->harga_satuan) - $this->formatMoneyFrom($value->diskon_satuan)));
		}

		return $this->formatMoneyTo($total);
	}

	/**
	 */	
	protected function getKlienAttribute($value)
	{
		return json_decode($value, true);
	}

	/**
	 *
	 */	
	protected function getTanggalDikeluarkanAttribute($value)
	{
		return $this->formatDateTo($value);
	}

	/**
	 *
	 */	
	protected function getTanggalJatuhTempoAttribute($value)
	{
		return $this->formatDateTo($value);
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

	public static function generateNomorTransaksiKeluar($kantor, $tanggal)
	{
		$prefix 	= 'INVIN'.$kantor['id'].$tanggal->format('m').$tanggal->format('y');
		$previous 	= self::where('nomor', 'like', $prefix.'%')->orderby('created_at', 'desc')->first();
		
		if($previous)
		{
			$suffix = explode('.', $orang['nip']);
			$suffix = ((int)$suffix[1] * 1) + 1;
		}
		else
		{
			$suffix = 1;
		}

		$suffix 	= str_pad($suffix, 4, '0', STR_PAD_LEFT);

		return $prefix.$suffix;
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
			// foreach ($value as $mention) 
			// {
			// 	$query 	= $query->where('klien', 'like', '%id%'.$mention.'%');
			// }
			// return $query;
		}

		return $query->where('kantor_id', $value);
	}
}
