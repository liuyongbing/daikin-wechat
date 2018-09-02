<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Model\Life;
use App\Http\Model\LifeType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class LifeTypeController extends Controller
{
    /**
     * 列表 - life type
     *
     * @return  mixed
     */
    // list
    public function index()
    {
        $input = Input::except('_token');
        
        $data = LifeType::orderBy('sort','desc')->paginate(9);
        
        return view('admin.life_type.index',compact('data'));
    }
    
    //  show 详细信息展示页
    public function show($id)
    {
        $data=LifeType::find($id);
        
        if(!$data){
            return redirect('admin/life_type');
        }
        
        return view('admin.life_type.show',compact('data'));
    }
        
    //update 修改
    public function update(Request $request, $id)
    {
        $input=Input::except('_token');
        
        $request->flash ();
        if($input){
            $roule=[
                'name'  => 'required',
            ];
            $message=[
                'name.required'=>'名称不能为空',
            ];
            $validator= Validator::make($input,$roule,$message);
            
            if($validator->passes()){
                $attributes = [
                    'name'      => $input['name'],
                    'sort'      => isset($input['sort'])?$input['sort']:0,
                    'state'     => 0
                ];
                if(LifeType::where('id',$id)->update($attributes)){
                    return back()->with('errors','更新成功');
                }else{
                    return back()->with('errors','更新失败稍后重试');
                }
            }else{
                return back()->withErrors($validator);
            }
        }else{
            return view('admin.life_type.index');
        }
    }
}
