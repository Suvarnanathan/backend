<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class JobExperience extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $endMonth=Carbon::parse( $this->end_date)->format('m');
        $startMonth=Carbon::parse( $this->start_date)->format('m');
        $diffMonth = $this->is_currently_work!=1 ? ($endMonth - $startMonth) :  (Carbon::now()->format('m') - $startMonth);
        $diffYear = $this->is_currently_work!=1 ? (date('Y', strtotime($this->end_date))-date('Y', strtotime($this->start_date)))
                            :(Carbon::now()->format('Y')-date('Y', strtotime($this->start_date)));
            return [
                'id'                 => $this->id,
                'userId'             => $this->user_id,
                'city'               => $this->city, 
                'company'            => $this->company,
                'convertStartDate'   => date(' F Y ', strtotime($this->start_date)),
                'convertEndDate'      => $this->is_currently_work!=1?date('F Y', strtotime($this->end_date)):"",
                'startDate'          =>  $this->start_date,
                'endDate'            =>  $this->end_date,
                'experience'           =>  $diffYear>0 ? ($diffYear .' yrs '.$diffMonth.' mos'):( $diffMonth.' mos'),
                'isCurrentlyWork'           =>$this->is_currently_work?true:false,
                'jobSubCategory'     =>[
                    'id'=>$this->jobSubCategory()->first()->id,
                    'name'=>$this->jobSubCategory()->first()->name,
                ],
                'country'=>[
                    'id'=>$this->country()->first()->id,
                    'name'=>$this->country()->first()->name,
                ],
                
            ];
        
    }
}
