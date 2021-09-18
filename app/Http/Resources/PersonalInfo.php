<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PersonalInfo extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $country=[];
        if($this->country !=null){
            $country=[
                'id' => $this->country->id,
                'name' => $this->country->name,
            ];

           
        }
        return
            [
                'id' => $this->id,
                'userId' => $this->user_id,
                'email' =>$this->user->email,
                'city' => $this->city!= null ? $this->city:"",
                'firstName'=>$this->first_name,
                'lastName'=>$this->last_name,
                'streetName' => $this->street_name != null ? $this->street_name:"",
                'postalCode' => $this->postal_code != null ? $this->postal_code:"",
                'gender' => $this->gender !=null ?$this->gender:"",
                'dob'   => $this->dob !=null ?$this->dob:"",
                'about' => $this->about != null ?$this->about :"",
                'hasProfile'=>$this->has_profile,
                'country' =>$this->country !=null ?$this->country:"",
                'profileImage'=>$this->profileImage!=null?asset($this->profileImage->public_path):asset('/Images/profile.png')
            ];
    }
}
