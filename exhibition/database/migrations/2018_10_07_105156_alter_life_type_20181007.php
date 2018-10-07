<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterLifeType20181007 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('life', function (Blueprint $table) {
            $table->string('url', 200)->default('')->after('title');
        });
        
        LifeType::insert([
            'id' => '4',
            'name' =>'家用分体空调',
            'sort' => '1',
            'state' => '0',
            'ctime' => '2018-10-07 11:11:11',
        ]);
        LifeType::insert([
            'id' => '5',
            'name' =>'家用中央空调',
            'sort' => '1',
            'state' => '0',
            'ctime' => '2018-10-07 11:11:11',
        ]);
        LifeType::insert([
            'id' => '6',
            'name' =>'空气净化设备',
            'sort' => '1',
            'state' => '0',
            'ctime' => '2018-10-07 11:11:11',
        ]);
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
