<?php

namespace TAkta\DokumenKunci\Models;

use TAkta\Infrastructures\Guid\GuidTrait;

use TAkta\UbiquitousLibraries\Datetimes\TanggalTrait;

use TAkta\Infrastructures\Models\BaseModel;

use Validator, Exception;

/**
 * Model DokumenKunci
 *
 * Digunakan untuk menyimpan data alamat
 * Ketentuan : 
 * 	- tidak bisa direct changes, tapi harus melalui fungsi tersedia (aggregate)
 * 	- auto generate id (guid)
 *
 * @package    TAkta
 * @subpackage DokumenKunci
 * @author     C Mooy <chelsy@thunderlab.id>
 */
class Dokumen extends BaseModel
{
	use GuidTrait;
	use TanggalTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table				= 'akta_dokumen';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */

	protected $fillable				=	[
											'_id'					,
											'judul'					,
											'paragraf'				,
											'status'				,
											// 'versi'					,
											'pemilik'				,
											'penulis'				,
											'mentionable'			,
											'fill_mention'			,
											'total_perubahan'		,
											'tanggal_pertemuan'		,
										];
	/**
	 * Basic rule of database
	 *
	 * @var array
	 */
	protected $rules				=	[
											'judul'					=> 'required',
											'jenis'					=> 'max:255',
											'paragraf.*.konten'		=> 'required',
											'paragraf.*.lock'		=> 'max:255',
											// 'paragraf.*.key'		=> 'max:255',
											// 'paragraf.*.padlock'	=> 'max:255',
											'status'				=> 'in:draft,pengajuan,renvoi,akta,minuta'
										];
	/**
	 * Date will be returned as carbon
	 *
	 * @var array
	 */
	protected $dates				= ['created_at', 'updated_at', 'deleted_at', 'tanggal_pertemuan'];
	
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

	protected $appends 				= ['id', 'tanggal_pembuatan', 'tanggal_sunting', ''];

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

	public function scopeKlien($query, $value)
	{
		return $query->where('pemilik.klien.nama', 'like', '%'.$value.'%');
	}

	public function scopeJudul($query, $value)
	{
		return $query->where('judul', 'like', '%'.$value.'%');
	}
}
