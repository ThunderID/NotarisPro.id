<?php

namespace Thunderlabid\Billing\Models;

use Thunderlabid\Billing\Models\Traits\Policies\IDRTrait;
use Thunderlabid\Billing\Models\Traits\Policies\TanggalTrait;

use Validator, Exception, Carbon\Carbon;

/**
 * Model Tagihan
 *
 * Digunakan untuk menyimpan data Tagihan.
 *
 * @package    Thunderlabid
 * @subpackage Billing
 * @author     C Mooy <chelsy@thunderlab.id>
 */
class Tagihan extends BaseModel
{
	use IDRTrait;
	use TanggalTrait;
	
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
											'id'				,
											'dikeluarkan_oleh'	,
											'dikeluarkan_untuk'	,
											'nomor_tagihan'		,
											'tanggal'			,
										];
	/**
	 * Basic rule of database
	 *
	 * @var array
	 */
	protected $rules				=	[
											'dikeluarkan_oleh'	=> 'required|max:255',
											'dikeluarkan_untuk'	=> 'required|max:255',
											'nomor_tagihan'		=> 'required|max:255',
											'tanggal'			=> 'date_format:"Y-m-d"',
										];
	/**
	 * Date will be returned as carbon
	 *
	 * @var array
	 */
	protected $dates				= ['created_at', 'updated_at', 'deleted_at', 'tanggal'];
	
	/**
	 * Date will be returned as carbon
	 *
	 * @var array
	 */
	protected $appends				= ['jatuh_tempo', 'total'];

	/**
	 * hidden data
	 *
	 * @var array
	 */
	protected $hidden				= 	[
											'created_at', 
											'updated_at', 
											'deleted_at', 
										];

	/* ---------------------------------------------------------------------------- RELATIONSHIP ----------------------------------------------------------------------------*/
	public function detail()
	{
		return $this->hasMany('\Thunderlabid\Billing\Models\TagihanDetail', 'tagihan_id');
	}

	/* ---------------------------------------------------------------------------- QUERY BUILDER ----------------------------------------------------------------------------*/
	
	/* ---------------------------------------------------------------------------- MUTATOR ----------------------------------------------------------------------------*/
	protected function setTanggalAttribute($value)
	{
		$this->attributes['tanggal']	= $this->formatDateFrom($value);
	}

	/* ---------------------------------------------------------------------------- ACCESSOR ----------------------------------------------------------------------------*/
	protected function getTanggalAttribute()
	{
		return $this->formatDateTo($this->attributes['tanggal']);
	}

	protected function getJatuhTempoAttribute()
	{
		return $this->formatDateTo(Carbon::parse($this->attributes['tanggal'])->addDays(2)->format('Y-m-d'));
	}

	protected function getTotalAttribute()
	{
		$sum 		= 0;

		foreach ($this->detail as $key => $value) 
		{
			$sum 	= $sum + ($value['attributes']['jumlah'] - $value['attributes']['diskon']);
		}
		return $this->formatMoneyTo($sum);
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

	/**
	 * add tagihan detail
	 *
	 */	
	public function addTagihanDetail($value)
	{
		$detail 		= new TagihanDetail;
		$detail->fill($value);
		$detail->tagihan_id	= $this->id;
		$detail->save();

		return $this;
	}


	/**
	 * remove tagihan detail
	 *
	 */	
	public function removeTagihanDetail($value)
	{
		$detail 		= TagihanDetail::findorfail($value);
		$detail->delete();

		return $this;
	}
		/* ---------------------------------------------------------------------------- SCOPES ----------------------------------------------------------------------------*/
}
