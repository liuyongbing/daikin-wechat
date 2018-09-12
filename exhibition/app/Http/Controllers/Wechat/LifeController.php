<?php

namespace App\Http\Controllers\Wechat;

use App\Http\Controllers\Controller;
use App\Http\Model\Designer;
use App\Http\Model\Life;
use App\Http\Model\LifeType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Repositories\LifeRepository;

class LifeController extends Controller
{
    /**
     * 住宅生活
     *
     * @table   Life
     * @return  mixed
     */
    // list
    public function index(Request $request)
    {
        $input=Input::except('_token');
        
        $types=LifeType::orderBy('sort','desc')->paginate(9);
        
        $cur_type_id= $types[0]->id;
        
        if(isset($input['cur_type_id']))
        {
            $cur_type_id = $input['cur_type_id'];
            
            $conditions = [
                'type_id' => $cur_type_id,
                'state' => 0
            ];
            $data = $this->getList($conditions, 9);
        }
        
        if ($data&&count($data)>0)
        {
            foreach ($data as $life_obj)
            {
                $life_obj->type = LifeType::find($life_obj->type_id)->name;
            }
        }
        
        return view('wechat.life.list', [
            'data' => $data,
            'types' => $types,
            'cur_type_id' => $cur_type_id,
        ]);
    }
    
    //  show 详细信息展示页
    public function show($id)
    {
        $data=Life::where('state',0)->find($id);
        
        if(!$data){
            abort(404);
        }
        
        $designer = [];
        $recommend = [];
        if (!empty($data->designer_id))
        {
            $designer = Designer::where(['state' => 0])->find($data->designer_id);
        }
        else
        {
            $conditions = [
                'type_id' => $data->type_id,
                'state' => 0
            ];
            $recommend = $this->getList($conditions, 3, $data->id);
        }
        
        $recommendCases = [];
        if (!empty($data->recommend_ids))
        {
            $recommendIds = json_decode($data->recommend_ids, true);
            $conditions = [
                'id' => $recommendIds,
                'state' => 0
            ];
            $recommendCases = $this->getList($conditions);
        }
        
        return view('wechat.life.detail', [
            'data'              => $data,
            'designer'          => $designer,
            'recommend'         => $recommend,
            'recommendCases'    => $recommendCases,
        ]);
    }
    
    protected function getList($conditions = [], $limit = null, $except = null)
    {
        $repository = new LifeRepository();
        $data = $repository->list($conditions, $limit, $except);
        
        return $data;
    }
}
