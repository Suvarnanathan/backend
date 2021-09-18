<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Certificate as CertificateResource;
class Certificate extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
      $certificateImage=null;
      if($this->certificateImage->first() != null){
      $certificateImage=[
        'publicPath'        => asset($this->certificateImage->first()->public_path),
        'thumbPath'         => asset($this->certificateImage->first()->thumb_path)
      ];
    }
        return [
            'id'                    => $this->id,
            'userId'                => $this->user_id,
            'name'                  => $this->name,
            'issuedOrganization'    => $this->issued_organization,
            'convertStartYear'      => date('F, Y ', strtotime($this->start_date)),
            'convertEndYear'        => date('F, Y ', strtotime($this->end_date)),
            'startDate'             => $this->start_date,
            'endDate'               => $this->end_date,
            'duration'              => date('Y', strtotime($this->end_date))-date('Y', strtotime($this->start_date)),
            'image'      => $certificateImage,      
            
        ];
        
    }
}
