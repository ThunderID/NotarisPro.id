<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHeaderTransaksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->create('header_transaksi', function (Blueprint $table) {
            $table->increments('id');
            $table->string('klien_id')->nullable();
            $table->string('klien_nama')->nullable();
            $table->string('kantor_id');
            $table->string('referensi_id')->nullable();
            $table->string('nomor_transaksi');
            $table->enum('tipe', ['billing_in', 'billing_out', 'bukti_kas_keluar', 'bukti_kas_masuk']);
            $table->datetime('tanggal_dikeluarkan');
            $table->datetime('tanggal_jatuh_tempo')->nullable();
            
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
        Schema::connection('mysql')->dropIfExists('header_transaksi');
    }
}
