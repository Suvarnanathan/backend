<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Education extends JsonResource
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
            'id'        => $this->id,
            'userId'    => $this->user_id,
            'school'    => $this->school,
            'courseName' => $this->course_name,
            'fieldOfStudy' => $this->field_of_study,
            'grade'     => $this->grade,
            'activityAndSociety' => $this->activity_and_society,
            'description' => $this->description,
            'convertStartDate'   => date('Y ', strtotime($this->start_date)),
            'convertEndDate'      => $this->is_currently_study!=1?date('Y', strtotime($this->end_date)):"",
            'startDate'          => $this->start_date,
            'endDate'            => $this->end_date,
            'duration'  => date('Y', strtotime($this->end_date)) - date('Y', strtotime($this->start_date)),
            'isCurrentlyStudy' => $this->is_currently_study?true:false,
        ];
    }
}
