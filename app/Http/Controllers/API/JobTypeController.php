<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\API\ApiBaseController as ApiBaseController;
use Illuminate\Http\Request;
use App\Models\JobType;
use App\Http\Resources\JobType as JobTypeResource;
class JobTypeController extends ApiBaseController
{
    //showing all job types
    public function index()
    {
        $jobTypes = JobType::all();
        if($jobTypes){
        return $this->sendResponse(JobTypeResource::collection($jobTypes), 'jobTypes retrieved successfully.');
        }
        return $this->sendError('jobTypes are not found.');

    }
}
