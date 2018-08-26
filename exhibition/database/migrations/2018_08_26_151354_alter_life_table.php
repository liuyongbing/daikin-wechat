<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterLifeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('life', function (Blueprint $table) {
            $table->string('title', 128)->default('')->after('type_id');
            $table->string('img', 128)->default('')->after('video');
            $table->integer('designer_id')->default(0)->after('desc');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
