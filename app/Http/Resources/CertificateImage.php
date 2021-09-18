<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CertificateImage extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'certificateId'     => $this->certificate_id,
            'image_name'        => $this->image_name,
            'publicPath'        => asset($this->public_path),
            'thumbPath'         => asset($this->thumb_path),
        ];
    }
}
