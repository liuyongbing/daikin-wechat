<?php

namespace App\Repositories;

use App\Http\Model\Life;

class LifeRepository
{
    public function list($conditions = [], $limit = null, $except = null)
    {
        $data = [];
        
        $query = Life::where($conditions);
        if(!empty($except))
        {
            $query->where('id', '!=', $except);
        }
        
        $query->orderBy('sort','desc')->orderBy('id','desc');
        
        if (!empty($limit))
        {
            $data = $query->paginate($limit);
        }
        else
        {
            $data = $query->get();
        }
        
        return $data;
    }
}