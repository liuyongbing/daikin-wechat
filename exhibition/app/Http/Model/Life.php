<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Life extends Model
{
    //
    protected $table='life';
    protected $primaryKey='id';
    protected $guarded=[]; //排除表字段不能修改；如果不填则表示都可以修改
    //public $timestamps=false;
    
    const CREATED_AT = 'ctime';
    const UPDATED_AT = 'ctime'; 
    
    protected $appends = ['img_url'];
    
    public function getImgUrlAttribute()
    {
        return env('APP_URL') . $this->img;
    }
}
