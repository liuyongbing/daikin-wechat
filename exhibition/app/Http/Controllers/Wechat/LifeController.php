<?php

namespace App\Http\Controllers\Wechat;

use App\Http\Controllers\Controller;
use App\Http\Model\Banner;
use App\Http\Model\Life;
use App\Http\Model\LifeType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class LifeController extends Controller
{
    /**
     * 住宅生活
     *
     * @table   Life
     * @return  mixed
     */
    // list
    public function index()
    {
        $input=Input::except('_token');
        
        $types=LifeType::all();
        
        $cur_type_id= $types[0]->id;
        
        if(isset($input['cur_type_id']))
            $cur_type_id = $input['cur_type_id'];
        
            $data=Life::where('state','!=',1)->where('type_id','=',$cur_type_id)->orderBy('sort','desc')->paginate(9);
        
        if ($data&&count($data)>0)
            foreach ($data as $life_obj){
                $life_obj->type = LifeType::find($life_obj->type_id)->name;        
            }
    
        return view('wechat.life.list',compact('data','types','cur_type_id'));
    }
    
    //  show 详细信息展示页
    public function show($id)
    {
        $data=Life::where('state',0)->find($id);
        
//         if(!$data){
//             abort(404);
//         }
        
        $types = LifeType::all();
        
        // dd($member);
        return view('wechat.life.detail',compact('data','types'));
    }
}
