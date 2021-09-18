<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\API\ApiBaseController as ApiBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\JobCategory;
use App\Models\User;
use App\Http\Resources\JobCategory as JobCategoryResource;

class JobCategoryController extends ApiBaseController
{
    //showing all the job categories
    public function index()
    {
        $allJobCategories = JobCategory::all();
        if(count($allJobCategories)!=0){
        return $this->sendResponse(JobCategoryResource::collection($allJobCategories), 'Job Categories retrieved successfully.');
        }
        return $this->sendResponse(JobCategoryResource::collection($allJobCategories),'Job Categories are not found.');

    }

    //create new job category
    public function store(Request $request)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'name' => 'required|unique:job_categories',
        ],
    [
        'name.required'=>'Job Category name is required'
    ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
            $jobCategory = new JobCategory();
            $jobCategory->name=$request->input('name');
            $jobCategory->slug=Str::slug($request->input('name'), '-');
            if($jobCategory->save()){
             return $this->sendResponse(null,'Job Category created successfully.');
            }
              return $this->sendError('Job Category create failed.');
    } 
   //showing job category
   public function show($id)
   {
       $jobCategory = JobCategory::find($id);
       if($jobCategory){
       return $this->sendResponse(new JobCategoryResource($jobCategory), 'jobCategory retrieved successfully.');
       }
       return $this->sendError('jobCategory is not found.');

   }
  
  

  //update job category details
  public function update(Request $request,$id){
   $validator = Validator::make($request->all(),
   [
     'name'     => 'required|unique:job_categories',   
   ],
   [
    'name.required'=>'Job Category name is required'

   ]
   );
   if ($validator->fails()) {
       return $this->sendError('Validation Error.', $validator->errors());
    } 
      $jobCategory = JobCategory::findOrFail($id);
      $jobCategory->name = $request->input('name');
      $jobCategory->slug = Str::slug($request->input('name'), '-');
       if($jobCategory->save()){
           return $this->sendResponse(null, 'JobCategory updated successfully.');
       }
        return $this->sendError('Job Category update failed.');

  }
  //delete job category
  public function destroy($id)
  {
    $jobCategory=JobCategory::find($id);
    if($jobCategory){
        $jobCategory->delete();
      return $this->sendResponse(null,'JobCategory deleted successfully.');
  }
    return $this->sendError('JobCategory is not found');
}
}
