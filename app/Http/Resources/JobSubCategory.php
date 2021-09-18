<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JobSubCategory extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $jobCategory=[
        'id'=>$this->jobCategory()->first()->id,
                'name'=>$this->jobCategory()->first()->name,
        ];
             return[            
            
            'id'=>$this->id,
            'jobCategory'=>$jobCategory,
            'name'=>$this->name
        
    ];
    }
}
