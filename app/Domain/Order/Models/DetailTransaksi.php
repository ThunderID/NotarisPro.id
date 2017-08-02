<?php

namespace App\Domain\Order\Models;

use Illuminate\Database\Eloquent\Model;

use Validator, Exception;

/**
 * Model DetailTransaksi
 *
 * @author     C Mooy <chelsy@thunderlab.id>
 */
class DetailTransaksi extends Model
{
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


	/* ---------------------------------------------------------------------------- RELATIONSHIP ----------------------------------------------------------------------------*/

	/* ---------------------------------------------------------------------------- QUERY BUILDER ----------------------------------------------------------------------------*/
	
	/* ---------------------------------------------------------------------------- MUTATOR ----------------------------------------------------------------------------*/

	/* ---------------------------------------------------------------------------- ACCESSOR ----------------------------------------------------------------------------*/

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
