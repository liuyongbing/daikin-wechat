<?php

namespace App\Repositories;

use App\Http\Model\Life;

class LifeRepository
{
    public function list($conditions = [], $limit = 9, $except = null)
    {
        $data = [];
        
        $query = Life::where($conditions);
        if(!empty($except))
        {
            $query->where('id', '!=', $except);
        }
        
        $query->orderBy('sort','desc')->orderBy('id','desc');
        $data = $query->paginate($limit);
        
        return $data;
    }
}