<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->integer('id', 10)->unsigned();
            $table->string('event', 255);
            $table->char('color');
            $table->text('description');
            $table->text('caption');
            $table->string('img', 255);
            $table->integer('kuota');
            $table->enum('level', ['beginer', 'intermediate', 'advance']);
            $table->dateTime('start');
            $table->dateTime('end');
            $table->integer('price');
            $table->tinyInteger('session');
            $table->string('event_type', 20);
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
        Schema::dropIfExists('events');
    }
}
