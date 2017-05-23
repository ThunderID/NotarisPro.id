<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKlienProgressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->create('klien_progress', function (Blueprint $table) {
            $table->increments('id');
            $table->string('klien_id');
            $table->string('akta_id');
            $table->string('template_id');
            $table->string('kantor_id');
            $table->string('penulis_id');
            $table->datetime('completed_at')->nullable();
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
        Schema::connection('mysql')->dropIfExists('klien_progress');
    }
}
