<?php

namespace App\Repositories;

use App\Http\Model\Life;

class DesignerRepository
{
    public function cases($designerId)
    {
        $data = [];
        
        $designerId = (int)$designerId;
        if (!empty($designerId))
        {
            $conditions = [
                'designer_id'   => $designerId,
                'state'         => 0
            ];
            $data = Life::where($conditions)->get();
        }
        
        return $data;
    }
}