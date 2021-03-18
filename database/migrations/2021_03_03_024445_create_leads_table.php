<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->integer('id', 10)->unsigned();
            $table->integer('event_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->enum('status', ['daftar', 'follow up', 'diterima', 'ditolak', 'dicicil', 'lunas', 'hadir']);
            $table->string('execute_by', 50);
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
        Schema::dropIfExists('leads');
    }
}
