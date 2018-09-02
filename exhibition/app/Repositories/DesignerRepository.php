<?php

namespace App\Repositories;

use App\Http\Model\Life;

class DesignerRepository
{
    public function cases($designerId, $except = null)
    {
        $data = [];
        
        $designerId = (int)$designerId;
        if (!empty($designerId))
        {
            $conditions = [
                'designer_id'   => $designerId,
                'state'         => 0
            ];
            
            $query = Life::where($conditions);
            
            if(!empty($except))
            {
                $query->where('id', '!=', $except);
            }
            $data = $query->get();
        }
        
        return $data;
    }
}