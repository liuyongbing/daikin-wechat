<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDesignersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('designers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 32)->default('');
            $table->string('title', 128)->default('');
            $table->string('img', 128)->default('');
            $table->string('desc', 5000)->default('');
            $table->integer('sort')->default(0);
            $table->tinyInteger('display')->default(0);
            $table->tinyInteger('state')->default(0);
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('designers');
    }
}
