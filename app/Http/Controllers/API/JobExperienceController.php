<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\API\ApiBaseController as ApiBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\JobExperience;
use App\Models\User;
use App\Models\JobSubCategory;
use App\Http\Resources\JobExperience as JobExperienceResource;


class JobExperienceController extends ApiBaseController
{
     //showing all the job categories
     public function index()
     {
         $allJobExperiences = JobExperience::all();
         if(count($allJobExperiences)!=0){
         return $this->sendResponse(JobExperienceResource::collection($allJobExperiences), 'Job Experiences retrieved successfully.');
         }
         return $this->sendResponse(JobExperienceResource::collection($allJobExperiences),'Job Experiences are not found.');
 
     }
     private function validateFields($request){
        $commonRequiredField=[
            'userId'=>'required',
        'jobSubCategoryId'=>'required',
        'company'=>'required',
        'countryId'=>'required',
        'city'=>'required',
        'startDate' =>'required|date',
        'isCurrentlyWork'=>'required',
        ];
     
      $commonValidMessage= [
        'jobSubCategoryId.required'=>'Job title is required',
          'company.required'  =>'Company name is required',
          'countryId.required'=>'Country is required',
          'city.required'=>'City is required',
          'startDate.required'=>'Start date is required',
      ]; 
      if($request->input('isCurrentlyWork')=== false){
        $commonRequiredField=array_merge($commonRequiredField,['endDate'  => 'required|date|after:startDate']);
        $commonValidMessage=array_merge($commonValidMessage,['endDate.required'  =>'End date is required']);
        $commonValidMessage=array_merge($commonValidMessage,['endDate.after'  =>'End date must be greater than  Start date']);

      }
          return[
            'required_fields'=>$commonRequiredField,
            'validation_messages'=> $commonValidMessage
          ];
       }
    
    
    //create new job experience
    public function store(Request $request)
    {
        $input = $request->all();
        $validation=self::validateFields($request);
        $validator = Validator::make($input,$validation['required_fields'],$validation['validation_messages']);
    
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
            $jobExperience = new JobExperience();
            $jobExperience->user_id=$request->input('userId');
            if(user::find($request->input('userId'))){
            $jobExperience->job_sub_category_id=$request->input('jobSubCategoryId');
            if(JobSubCategory::find($request->input('jobSubCategoryId'))){
            $jobExperience->company=$request->input('company');
            $jobExperience->country_id=$request->input('countryId');
            $jobExperience->city=$request->input('city');
            $jobExperience->start_date=$request->input('startDate');
            $jobExperience->is_currently_work=$request->input('isCurrentlyWork');
            if($jobExperience->is_currently_work==true){
                if($jobExperience->save()){
                    return $this->sendResponse(null,'Job Experience created successfully.');
                   }
                }
                else{
            $jobExperience->end_date=$request->input('endDate');
            if($jobExperience->save()){
                return $this->sendResponse(null,'Job Experience created successfully.');
               }
                }  
        }
        else{
            return $this->sendError('job sub categories are not available');
    
        }}
        else{
            return $this->sendError('user isnot found');

        }
              return $this->sendError('Job Experience create failed.');
    } 
    //showing job sub experience
   public function show($id)
   {
       $jobExperience = JobExperience::find($id);
       if($jobExperience){
       return $this->sendResponse(new JobExperienceResource($jobExperience), 'Job Experience retrieved successfully.');
       }
       return $this->sendError('Job Experience is not found.');

   }
   //update job sub category details
  public function update(Request $request,$id){
    $input = $request->all();
    $validation=self::validateFields($request);
    $validator = Validator::make($input,$validation['required_fields'],$validation['validation_messages']);
    if ($validator->fails()) {
        return $this->sendError('Validation Error.', $validator->errors());
     } 
       $jobExperience = JobExperience::findOrFail($id);
       $jobExperience->user_id=$request->input('userId');
       $jobExperience->job_sub_category_id=$request->input('jobSubCategoryId');
       $jobExperience->company=$request->input('company');
       $jobExperience->country_id=$request->input('countryId');
       $jobExperience->city=$request->input('city');
       $jobExperience->start_date=$request->input('startDate');
       $jobExperience->end_date=$request->input('endDate');
       $jobExperience->is_currently_work=$request->input('isCurrentlyWork');
        if($jobExperience->save()){
            return $this->sendResponse(null, 'Job Experience updated successfully.');
        }
        return $this->sendError('Job Experience update failed.');
 
   }
     //delete job experience
  public function destroy($id)
  {
    $jobExperience=JobExperience::find($id);
    if($jobExperience){
        $jobExperience->delete();
      return $this->sendResponse(null,'Job Experience deleted successfully.');
  }
    return $this->sendError('Job Experience is not found');
}
//get user's experiences 
public function getJobExperiencesByUserId($userId){
  $user=User::find($userId);
  if($user){
  $experiences=$user->jobExperience()->orderBy('start_date','DESC')->get();
  if(count($experiences)!=0){
  return $this->sendResponse(JobExperienceResource::collection($experiences), 'job experiences retrieved successfully.');
  }
  return $this->sendResponse(JobExperienceResource::collection($experiences), 'job experiences are not found');

}
    return $this->sendError('user is not  found');

}

}
