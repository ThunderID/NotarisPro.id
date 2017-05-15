<?php

namespace App\Domain\Akta\Models;

use App\Infrastructure\Traits\GuidTrait;
use App\Infrastructure\Traits\TanggalTrait;

use App\Infrastructure\Models\BaseModel;

use Validator, Exception;

/**
 * Model DokumenKunci
 *
 * Digunakan untuk menyimpan data alamat
 * Ketentuan : 
 * 	- tidak bisa direct changes, tapi harus melalui fungsi tersedia (aggregate)
 * 	- auto generate id (guid)
 *
 * @author     C Mooy <chelsy@thunderlab.id>
 */
class Template extends BaseModel
{
	use GuidTrait;
	use TanggalTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table				= 'akta_template';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */

	protected $fillable				=	[
											'_id'					,
											'judul'					,
											'paragraf'				,
											'pemilik'				,
											'penulis'				,
											'status'				,
											'mentionable'			,
											'jumlah_pihak'			,
											'dokumen_objek'			,
											'dokumen_pihak'			,
											'dokumen_saksi'			,
										];
	/**
	 * Basic rule of database
	 *
	 * @var array
	 */
	protected $rules				=	[
											'judul'					=> 'required',
											// 'paragraf.*.konten'		=> '',
											'status'				=> 'in:draft,publish',
											'jumlah_pihak'			=> 'numeric',
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

	protected $appends 				= ['id', 'tanggal_pembuatan', 'tanggal_sunting'];

	/* ---------------------------------------------------------------------------- RELATIONSHIP ----------------------------------------------------------------------------*/

	/* ---------------------------------------------------------------------------- QUERY BUILDER ----------------------------------------------------------------------------*/
	
	/* ---------------------------------------------------------------------------- MUTATOR ----------------------------------------------------------------------------*/

	/* ---------------------------------------------------------------------------- ACCESSOR ----------------------------------------------------------------------------*/
	
	public function getIdAttribute($value = NULL)
	{
		return $this->attributes['_id'];
	}
	
	public function getTanggalPembuatanAttribute($value = NULL)
	{
		return $this->formatDateTo($this->attributes['created_at']);
	}

	public function getTanggalSuntingAttribute($value = NULL)
	{
		return $this->formatDateTo($this->attributes['updated_at']);
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

	public function scopeStatus($query, $value)
	{
		if(is_array($value))
		{
			return $query->whereIn('status', $value);
		}

		return $query->where('status', $value);
	}

	public function scopeKantor($query, $value)
	{
		if(is_array($value))
		{
			return $query->whereIn('pemilik.kantor.id', $value);
		}

		return $query->where('pemilik.kantor.id', $value);
	}

	public function scopePemilik($query, $value)
	{
		return $query->where('pemilik.orang.id', $value);
	}

	public function scopeDraft($query, $value)
	{
		return $query->where(function($query) use ($value){$query->where('status', 'draft')->where('penulis.id', $value);});
	}
	
	public function scopeDraftOrPublished($query, $value)
	{
		return $query->where(function($query) use ($value){$query->where('status', 'draft')->where('penulis.id', $value['penulis']['id']);})->orwhere('status', 'publish');
	}
}
