<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Model\Banner;
use App\Http\Model\Designer;
use App\Http\Model\Life;
use App\Http\Model\LifeType;
use App\Repositories\DesignerRepository;
use App\Repositories\LifeRepository;
use App\Repositories\UploadRepository;
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
        {
            $cur_type_id = $input['cur_type_id'];
        }
        
        $data = [];
        $conditions = [
            'type_id' => $cur_type_id,
            'state' => 0
        ];
        $data = $this->getList($conditions, 9);
        
        if ($data&&count($data)>0)
        {
            foreach ($data as $life_obj){
                $life_obj->type = LifeType::find($life_obj->type_id)->name;
            }
        }
        
        return view('admin.life.index', [
            'data' => $data,
            'types' => $types,
            'cur_type_id' => $cur_type_id,
        ]);
    }
        
    // create 新增页面
    public function create()
    {
        $types = LifeType::all();
        
        $designers = Designer::where('state','!=',1)->get();
        
        $designerRep = new DesignerRepository();
        $cases = [];
        
        $recommendIds = [];
        
        return view('admin.life.create', [
            'cases'         => $cases,
            'designers'     => $designers,
            'recommendIds'  => $recommendIds,
            'types'         => $types,
        ]);
    }
    // store 添加到数据库
    public function store(Request $request)
    {
        $input=Input::except('_token');
        $request->flash();
        
        if($input){
            $roule=[
                'type_id'=>'required',
                'title'=>'required',
                //'img'=>'required',
                'video'=>'required'
            ];
            $message=[
                'type_id.required'=>'分类不能为空',
                'title.required'=>'标题不能为空',
                //'img.required'=>'缩略图不能为空',
                'video.required'=>'请录入视频信息'
            ];
            $validator= Validator::make($input,$roule,$message);
            if($validator->passes()){
                $repository = new UploadRepository();
                $attributes = [
                    'type_id'       => !empty($input['type_id']) ? (int)$input['type_id'] : 0,
                    'title'         => !empty($input['title']) ? $input['title'] : '',
                    'img'           => $repository->upload($request, 'life'),
                    'video'         => !empty($input['video']) ? $input['video'] : '',
                    'desc'          => !empty($input['desc']) ? $input['desc'] : '',
                    'designer_id'   => !empty($input['designer_id']) ? (int)$input['designer_id'] : 0,
                    'recommend_ids' => !empty($input['recommend_ids']) ? json_encode($input['recommend_ids']) : '',
                    'sort'          => isset($input['sort'])?$input['sort']:0,
                    'display'       => isset($input['display'])?$input['display']:1,
                    'state'         => 0
                ];
                if($life=Life::create($attributes)){
                    return back()->with('errors','添加成功');
                }else{
                    return back()->with('errors','添加失败稍后重试');
                }
            }else{
                return back()->withErrors($validator);
            }
        }else{
            return view('admin.life.index');
        }
    }
    
    //  show 详细信息展示页
    public function show($id)
    {
        $data=Life::where('state',0)->find($id);
        
        if(!$data){
            return redirect('admin/life');
        }
        
        $types = LifeType::all();
        
        $designers = Designer::where('state','!=',1)->get();
        
        $designerRep = new DesignerRepository();
        $cases = $designerRep->cases($data->designer_id, $data->id);
        
        $recommendIds = [];
        if (!empty($data->recommend_ids))
        {
            $recommendIds = json_decode($data->recommend_ids, true);
        }
        
        return view('admin.life.show', [
            'cases'         => $cases,
            'data'          => $data,
            'designers'     => $designers,
            'recommendIds'  => $recommendIds,
            'types'         => $types,
        ]);
    }
        
    //update 修改
    public function update(Request $request, $id)
    {
        $input=Input::except('_token');
        $request->flash ();
        if($input){
            $roule=[
                'type_id'=>'required',
                'title'=>'required',
                //'img'=>'required',
                'video'=>'required'
            ];
            $message=[
                'type_id.required'=>'分类不能为空',
                'title.required'=>'标题不能为空',
                //'img.required'=>'缩略图不能为空',
                'video.required'=>'请录入视频信息'
            ];
            $validator= Validator::make($input,$roule,$message);
            //print_r($input);die;
            
            if($validator->passes()){
                $repository = new UploadRepository();
                $attributes = [
                    'type_id'       => !empty($input['type_id']) ? (int)$input['type_id'] : 0,
                    'title'         => !empty($input['title']) ? $input['title'] : '',
                    'img'           => $repository->upload($request, 'life'),
                    'video'         => !empty($input['video']) ? $input['video'] : '',
                    'desc'          => !empty($input['desc']) ? $input['desc'] : '',
                    'designer_id'   => !empty($input['designer_id']) ? (int)$input['designer_id'] : 0,
                    'recommend_ids' => !empty($input['recommend_ids']) ? json_encode($input['recommend_ids']) : '',
                    'sort'          => isset($input['sort'])?$input['sort']:0,
                    'display'       => isset($input['display'])?$input['display']:1,
                    'state'         => 0
                ];
                if(Life::where('id',$id)->update($attributes)){
                    return back()->with('errors','更新成功');
                }else{
                    return back()->with('errors','更新失败稍后重试');
                }
            }else{
                return back()->withErrors($validator);
            }
        }else{
            return view('admin.life.index');
        }        
    }    
    
    public function destroy()
    {
        if($input=Input::all()){
            $obj=Life::find($input['id']);
            $obj->state=1;
            $obj->save();
            return response()->json(array('msg' => '删除成功'));
        }else{
            return false;
        }
    }
    
    public function listBanner(){
        $data=Banner::where('state','!=',1)->where('type','=','life')->orderBy('sort','desc')->paginate(9);        
        return view('admin.life.listBanner',compact('data'));
    }
    
    public function createBanner(){
        $type='life';
        return view('admin.life.createBanner',compact('type'));
    }
    
    // store 添加到数据库
    public function storeBanner(Request $request)
    {
        $input=Input::except('_token');
        $request->flash();
        
        if($input){
            $roule=[
                    'img'=>'required'
            ];
            $message=[
                    'img.required'=>'请上传图片'
                    
            ];
            $validator= Validator::make($input,$roule,$message);
            if($validator->passes()){
                $file=[
                        'type'=>$input['type'],
                        'img'=>$input['img'],
                        'url'=>$input['url'],
                        'sort'=>isset($input['sort'])?$input['sort']:0,
                        'display'=>isset($input['display'])?$input['display']:1,
                        'state'=>0
                ];
                if($obj=Banner::create($file)){
                    return back()->with('errors','添加成功');
                }else{
                    return back()->with('errors','添加失败稍后重试');
                }
            }else{
                return back()->withErrors($validator);
            }
        }else{
            return view('admin.life.listBanner');
        }
    }
    
    // store 添加到数据库
    public function updateBanner(Request $request,$id)
    {
        $input=Input::except('_token');
        $request->flash();
        
        if($input){
            $roule=[
                    'img'=>'required'
            ];
            $message=[
                    'img.required'=>'请上传图片'
                    
            ];
            $validator= Validator::make($input,$roule,$message);
            if($validator->passes()){
                $file=[
                        'type'=>$input['type'],
                        'img'=>$input['img'],
                        'url'=>$input['url'],
                        'sort'=>isset($input['sort'])?$input['sort']:0,
                        'display'=>isset($input['display'])?$input['display']:1,
                        'state'=>0
                ];
                if(Banner::where('id',$id)->update($file)){
                    return back()->with('errors','更新成功');
                }else{
                    return back()->with('errors','更新失败稍后重试');
                }                
            }else{
                return back()->withErrors($validator);
            }
        }else{
            return view('admin.life.listBanner');
        }
    }
    
    //  show 详细信息展示页
    public function showBanner($id)
    {
        $type='life';        
        $data=Banner::where('state',0)->find($id);
        
        if(!$data){
            return redirect('admin/life/listBanner');
        }
        
        return view('admin.life.showBanner',compact('type','data'));
    }
        
    public function delBanner()
    {
        if($input=Input::all()){
            $obj=Banner::find($input['id']);
            $obj->state=1;
            $obj->save();
            return response()->json(array('msg' => '删除成功'));
        }else{
            return false;
        }
    }
    
    protected function getList($conditions = [], $limit = null, $except = null)
    {
        $repository = new LifeRepository();
        $data = $repository->list($conditions, $limit, $except);
        
        return $data;
    }
}
