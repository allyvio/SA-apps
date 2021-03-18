<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('progress', function (Blueprint $table) {
            $table->integer('id')->unsigned();
            $table->integer('lead_id')->unsigned();
            $table->string('reason', 125);
            $table->enum('status', ['follow up', 'ditolak', 'diterima', 'dicicil', 'dibayar', 'hadir']);
            $table->string('ref_information', 2550);
            $table->integer('nominal')->unsigned();
            $table->string('file', 125);
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('progress');
    }
}
