<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Http\Model\LifeType;

class UpdateLifeType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        LifeType::where('id', 1)->update(['name' =>'口味生活篇']);
        LifeType::where('id', 3)->update(['name' =>'用户案例篇']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        LifeType::where('id', 1)->update(['name' =>'用户案例篇']);
        LifeType::where('id', 3)->update(['name' =>'New Lifestyle篇']);
    }
}
