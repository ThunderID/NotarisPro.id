<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAttendanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->create('user_attendance', function (Blueprint $table) {
            $table->increments('id');
            $table->string('pengguna_id');
            $table->string('kantor_id');
            $table->text('aktivitas');
            $table->text('deskripsi');
            $table->datetime('jam_masuk');
            $table->datetime('jam_keluar');
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
        Schema::connection('mysql')->dropIfExists('user_attendance');
    }
}
