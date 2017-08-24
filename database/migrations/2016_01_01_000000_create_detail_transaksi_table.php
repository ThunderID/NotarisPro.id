<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailTransaksiTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::connection('mysql')->create('detail_transaksi', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('header_transaksi_id');

			$table->string('referensi_id')->nullable();
			
			$table->string('item');
			$table->string('deskripsi');
			$table->integer('kuantitas');
			$table->double('harga_satuan');
			$table->double('diskon_satuan');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::connection('mysql')->dropIfExists('detail_transaksi');
	}
}
