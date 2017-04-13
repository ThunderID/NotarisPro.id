<?php

namespace TTagihan\Tagihan\Models;

use TTagihan\Infrastructures\Guid\GuidTrait;

use TTagihan\UbiquitousLibraries\Datetimes\TanggalTrait;
use TTagihan\UbiquitousLibraries\Currencies\IDRTrait;

use TTagihan\Infrastructures\Models\BaseModel;

use Validator, Exception;

/**
 * Model Tagihan
 *
 * Digunakan untuk menyimpan data alamat
 * Ketentuan : 
 * 	- tidak bisa direct changes, tapi harus melalui fungsi tersedia (aggregate)
 * 	- auto generate id (guid)
 *
 * @package    TTagihan
 * @subpackage Tagihan
 * @author     C Mooy <chelsy@thunderlab.id>
 */
class Tagihan extends BaseModel
{
	use GuidTrait;
	use TanggalTrait;
	use IDRTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table				= 'tagihan';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */

	protected $fillable				=	[
											'_id'					,
											'nomor'					,
											'tanggal_dikeluarkan'	,
											'tanggal_jatuh_tempo'	,
											'details'				,
											'oleh'					,
											'untuk'					,
										];
	/**
	 * Basic rule of database
	 *
	 * @var array
	 */
	protected $rules				=	[
											'nomor'						=> 'max:255',
											'tanggal_dikeluarkan'		=> 'date_format:"Y-m-d"',
											'tanggal_jatuh_tempo'		=> 'date_format:"Y-m-d"',
											'details.*.deskripsi'		=> 'max:255',
											'details.*.harga_satuan'	=> 'numeric',
											'details.*.diskon_satuan'	=> 'numeric',
											'details.*.jumlah_item'		=> 'numeric',
											'oleh.id'					=> 'required|max:255',
											'oleh.nama'					=> 'required|max:255',
											'untuk.id'					=> 'required|max:255',
											'untuk.nama'				=> 'required|max:255',
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
											'_id',
											'created_at', 
											'updated_at', 
											'deleted_at', 
										];

	protected $appends 				= ['id', 'total'];

	/* ---------------------------------------------------------------------------- RELATIONSHIP ----------------------------------------------------------------------------*/

	/* ---------------------------------------------------------------------------- QUERY BUILDER ----------------------------------------------------------------------------*/
	
	/* ---------------------------------------------------------------------------- MUTATOR ----------------------------------------------------------------------------*/
	
	public function setTanggalDikeluarkanAttribute($value)
	{
		$this->attributes['tanggal_dikeluarkan'] = $this->formatDateFrom($value);
	}

	public function setTanggalJatuhTempoAttribute($value)
	{
		$this->attributes['tanggal_jatuh_tempo'] = $this->formatDateFrom($value);
	}

	public function setDetailsAttribute($value)
	{
		foreach ($value as $key2 => $value2) 
		{
			$value[$key2]['harga_satuan']	= $this->formatMoneyFrom($value2['harga_satuan']);
			$value[$key2]['diskon_satuan']	= $this->formatMoneyFrom( $value2['diskon_satuan']);
		}

		$this->attributes['details'] 		= $value;
	}


	/* ---------------------------------------------------------------------------- ACCESSOR ----------------------------------------------------------------------------*/
	
	public function getIdAttribute($value = NULL)
	{
		return $this->attributes['_id'];
	}
	
	public function getTanggalDikeluarkanAttribute($value = NULL)
	{
		return $this->formatDateTo($this->attributes['tanggal_dikeluarkan']);
	}

	public function getTanggalJatuhTempoAttribute($value = NULL)
	{
		return $this->formatDateTo($this->attributes['tanggal_jatuh_tempo']);
	}

	public function getDetailsAttribute($value = NULL)
	{
		$value 		= $this->attributes['details'];
		
		foreach ($value as $key2 => $value2) 
		{
			$value[$key2]['harga_satuan']	= $this->formatMoneyTo($value2['harga_satuan']);
			$value[$key2]['diskon_satuan']	= $this->formatMoneyTo( $value2['diskon_satuan']);
		}

		return $value;
	}

	public function getTotalAttribute($value = NULL)
	{
		$total 		= 0;
		$value 		= $this->attributes['details'];
		
		foreach ($value as $key2 => $value2) 
		{
			$total 	= ($value2['harga_satuan'] - $value2['diskon_satuan']) * $value2['jumlah_item'];
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

	public function scopeKantor($query, $value)
	{
		if(is_array($value))
		{
			return $query->whereIn('oleh.id', $value);
		}

		return $query->where('oleh.id', $value);
	}
}
