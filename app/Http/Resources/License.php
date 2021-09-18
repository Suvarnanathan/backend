<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\License as licenseResource;

class License extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */
  public function toArray($request)
  {
    $licenseImage = null;
    if ($this->licenseImage->first() != null) {
      $licenseImage = [
        'publicPath'        => asset($this->licenseImage->first()->public_path),
        'thumbPath'         => asset($this->licenseImage->first()->thumb_path)
      ];
    }
    return [
      'id'                    => $this->id,
      'userId'                => $this->user_id,
      'image'                 => $licenseImage,
      'title'                 =>$this->title

    ];
  }
}
