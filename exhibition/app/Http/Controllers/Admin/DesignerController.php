<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Model\Designer;
use App\Http\Model\Life;
use App\Http\Model\LifeType;
use App\Repositories\UploadRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Repositories\DesignerRepository;

class DesignerController extends Controller
{
    /**
     * 列表 - 设计师
     *
     * @return  mixed
     */
    // list
    public function index()
    {
        $input = Input::except('_token');
        
        $data = Designer::where('state','!=',1)->orderBy('sort','desc')->paginate(9);
        
        return view('admin.designer.index',compact('data'));
    }
    
    // create 新增页面
    public function create()
    {
        $types = LifeType::all();
        $designers = [];
        return view('admin.designer.create',compact('types', 'designers'));
    }
    // store 添加到数据库
    public function store(Request $request)
    {
        $input=Input::except('_token');
        $request->flash();
        
        if($input){
            $roule=[
                'name'  => 'required',
                'title' =>'required',
                //'img' =>'required',
                'desc'  =>'required'
            ];
            $message=[
                'name.required'=>'姓名不能为空',
                'title.required'=>'标题不能为空',
                //'img.required'=>'缩略图不能为空',
                'desc.required'=>'说明内容不能为空'
            ];
            $validator= Validator::make($input,$roule,$message);
            if($validator->passes()){
                $repository = new UploadRepository();
                $attributes = [
                    'name'      => $input['name'],
                    'title'     => $input['title'],
                    'img'       => $repository->upload($request, 'designer'),
                    'desc'      => $input['desc'],
                    'sort'      => isset($input['sort'])?$input['sort']:0,
                    'display'   => isset($input['display'])?$input['display']:1,
                    'state'     => 0
                ];
                
                if($designer=Designer::create($attributes)){
                    return back()->with('errors','添加成功');
                }else{
                    return back()->with('errors','添加失败稍后重试');
                }
            }else{
                return back()->withErrors($validator);
            }
        }else{
            return view('admin.designer.index');
        }
    }
    
    //  show 详细信息展示页
    public function show($id)
    {
        $data=Designer::where('state',0)->find($id);
        
        if(!$data){
            return redirect('admin/designer');
        }
        
        return view('admin.designer.show',compact('data'));
    }
        
    //update 修改
    public function update(Request $request, $id)
    {
        $input=Input::except('_token');
        
        $request->flash ();
        if($input){
            $roule=[
                'name'  => 'required',
                'title' =>'required',
                //'img' =>'required',
                'desc'  =>'required'
            ];
            $message=[
                'name.required'=>'姓名不能为空',
                'title.required'=>'标题不能为空',
                //'img.required'=>'缩略图不能为空',
                'desc.required'=>'说明内容不能为空'
            ];
            $validator= Validator::make($input,$roule,$message);
            
            if($validator->passes()){
                $repository = new UploadRepository();
                $attributes = [
                    'name'      => $input['name'],
                    'title'     => $input['title'],
                    'img'       => $repository->upload($request, 'designer'),
                    'desc'      => $input['desc'],
                    'sort'      => isset($input['sort'])?$input['sort']:0,
                    'display'   => isset($input['display'])?$input['display']:1,
                    'state'     => 0
                ];
                if(Designer::where('id',$id)->update($attributes)){
                    return back()->with('errors','更新成功');
                }else{
                    return back()->with('errors','更新失败稍后重试');
                }
            }else{
                return back()->withErrors($validator);
            }
        }else{
            return view('admin.designer.index');
        }
    }
    
    public function destroy()
    {
        if($input=Input::all()){
            $obj=Designer::find($input['id']);
            $obj->state=1;
            $obj->save();
            return response()->json(array('msg' => '删除成功'));
        }else{
            return false;
        }
    }
    
    // 设计师的所有案例: 用于推荐设计师相关案例
    public function cases(Request $request, DesignerRepository $repository)
    {
        $designerId = $request->input('designer_id', '');
        $except     = $request->input('except', null);
        
        return $repository->cases($designerId, $except);
    }
}
