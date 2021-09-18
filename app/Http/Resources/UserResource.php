<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    
     
    public function toArray($request)
    {
       
        $role=[
            "id"=>$this->roles->first()->id,
            "name"=>$this->roles->first()->name,
         ];
          
       return[
        'id' => $this->id,
        'firstName'=>$this->personalInfo->first_name,
        'lastName'=>$this->personalInfo->last_name,
        'email' => $this->email,
        'role'=>$role,
        'created_at'=>$this->created_at->format('m/d/Y'),
        'updated_at'=>$this->updated_at->format('m/d/Y'),
        'profileImage'=>$this->personalInfo->profileImage!=null?asset($this->personalInfo->profileImage->public_path):asset('/Images/profile.png')

       ];
       
    }
}
