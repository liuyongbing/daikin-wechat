<?php

namespace App\Repositories;

use App\Http\Model\Life;

class LifeRepository
{
    public function list($conditions = [], $limit = null, $except = null)
    {
        $data = [];
        
        $query = Life::select();
        
        if (isset($conditions['id']))
        {
            if (is_array($conditions['id']))
            {
                $query->whereIn('id', $conditions['id']);
            }
            else
            {
                $query->where(['id' => $conditions['id']]);
            }
        }
        
        if (isset($conditions['type_id']))
        {
            $query->where(['type_id' => $conditions['type_id']]);
        }
        
        if (isset($conditions['state']))
        {
            $query->where(['state' => $conditions['state']]);
        }
        
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