<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->integer('id', 10)->unsigned();
            $table->string('name', 50);
            $table->string('email', 100)->unique();
            $table->string('phone', 15)->unique();
            $table->string('description', 2550)->nullable();
            $table->string('avatar', 125)->nullable();
            $table->string('last_job', 125)->nullable();
            $table->string('last_education', 125)->nullable();
            $table->string('address')->nullable();
            $table->string('origin_address')->nullable();
            $table->enum('gender', ['male', 'female']);
            $table->dateTime('birth_day');
            $table->string('place_of_birth', 125)->nullable();
            $table->string('current_institution', 125)->nullable();
            $table->string('instagram', 125)->nullable();
            $table->string('linkedin', 125)->nullable();
            $table->string('github', 125)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
