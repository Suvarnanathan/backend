<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\ApiBaseController as ApiBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\JobSubCategory;
use App\Models\JobCategory;
use App\Http\Resources\JobSubCategory as JobSubCategoryResource;
use App\Http\Resources\JobSubCategoryByJobCategory as JobSubCategoryByJobCategoryResource;

class JobSubCategoryController extends ApiBaseController
{
       //showing all the job sub categories
    public function index()
    {
        $allJobSubCategories = JobSubCategory::all();
        if(count($allJobSubCategories)!=0){
        return $this->sendResponse(JobSubCategoryResource::collection($allJobSubCategories), 'Job SubCategories retrieved successfully.');
        }
        return $this->sendResponse(JobSubCategoryResource::collection($allJobSubCategories),'Job SubCategories are not found.');

    }

    //create new job sub category
    public function store(Request $request)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'jobCategoryId'=>'required',
            'name' => 'required',
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
            $jobSubCategory = new JobSubCategory();
            $jobSubCategory->job_category_id=$request->input('jobCategoryId');
            $jobSubCategory->name=$request->input('name');
            $jobSubCategory->slug=Str::slug($request->input('name'), '-');
            if($jobSubCategory->save()){
             return $this->sendResponse(null,'job SubCategory created successfully.');
            }
              return $this->sendError('job SubCategory create failed.');
    } 
   //showing job sub category
   public function show($id)
   {
       $jobSubCategory = JobSubCategory::find($id);
       if($jobSubCategory){
       return $this->sendResponse(new JobSubCategoryResource($jobSubCategory), 'job SubCategory retrieved successfully.');
       }
       return $this->sendError('job SubCategory is not found.');
   }
  
  

  //update job sub category details
  public function update(Request $request,$id){
   $validator = Validator::make($request->all(),
   [
    'jobCategoryId'=>'required',
     'name'     => 'required',   
   ]
   );
   if ($validator->fails()) {
       return $this->sendError('Validation Error.', $validator->errors());
    } 
      $jobSubCategory = JobSubCategory::findOrFail($id);
      $jobSubCategory->job_category_id=$request->input('jobCategoryId');
      $jobSubCategory->name = $request->input('name');
      $jobSubCategory->slug = Str::slug($request->input('name'), '-');
       if($jobSubCategory->save()){
           return $this->sendResponse(null, 'Job SubCategory updated successfully.');
       }
       return $this->sendError('Job SubCategory update failed.');


  }
  //delete job sub category
  public function destroy($id)
  {
    $jobSubCategory=JobSubCategory::find($id);
    if($jobSubCategory){
        $jobSubCategory->delete();
      return $this->sendResponse(null,'Job SubCategory deleted successfully.');
  }
    return $this->sendError('Job SubCategory is not found');
}
public function getJobSubCategoriesByJobCategoryId($jobCategoryId){
  $jobCategory=JobCategory::find($jobCategoryId);
  if($jobCategory){
    $jobSubCats=$jobCategory->jobSubCategories()->get();
    if(count($jobSubCats)!=0){
      return $this->sendResponse(JobSubCategoryByJobCategoryResource::collection($jobSubCats), 'job SubCategories retrieved successfully.');
  }
  return $this->sendResponse(JobSubCategoryByJobCategoryResource::collection($jobSubCats), 'job SubCategories are not found.');

} 
  return $this->sendError('job Category is not found');
}
}

