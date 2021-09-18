<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\ApiBaseController as ApiBaseController;
use App\Models\Education;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Education as EducationResource;


class EducationController extends ApiBaseController
{
    public function index()
    {
        $educations = Education::all();
        if ($educations->isNotEmpty()) {
            return $this->sendResponse(EducationResource::collection($educations), 'Educations retrieved successfully.');
        }
        return $this->sendResponse(EducationResource::collection($educations), 'Educations not found');
    }

    private function validateFields($request)
    {
        $commonRequiredField = [
            'userId'          => 'required',
            'school'          => 'required',
            'courseName'       => 'required',
            'fieldOfStudy' => 'required',
            'grade' => 'required',
            'startDate'       => 'required',
        ];

        $commonValidMessage = [
            'school.required' => 'School name is required.',
            'courseName.required' => 'Course name is required.',
            'fieldOfStudy.required' => 'Field of study is required.',
            'grade.required' => 'Grade is required.',
            'startDate.required' => 'Start date is required.'
        ];
        if ($request->input('isCurrentlyStudy') === false) {
            $commonRequiredField = array_merge($commonRequiredField, ['endDate'  => 'required|date|after:startDate']);
            $commonValidMessage = array_merge($commonValidMessage, ['endDate.required'  => 'End date is required']);
            $commonValidMessage = array_merge($commonValidMessage, ['endDate.after'  => 'End date must be greater than  Start date']);
        }
        return [
            'required_fields' => $commonRequiredField,
            'validation_messages' => $commonValidMessage
        ];
    }


    public function store(Request $request)
    {

        $input = $request->all();
        $validation = self::validateFields($request);
        $validator = Validator::make($input, $validation['required_fields'], $validation['validation_messages']);
       
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $education = new Education();
        $education->user_id      = $request->input('userId');
        $education->school       = $request->input('school');
        $education->course_name  = $request->input('courseName');
        $education->field_of_study     = $request->input('fieldOfStudy');
        $education->grade     = $request->input('grade');
        $education->activity_and_society     = $request->input('activityAndSociety');
        $education->description     = $request->input('description');
        $education->start_date   = $request->input('startDate');
        $education->end_date     = $request->input('endDate');
        $education->is_currently_study  = $request->input('isCurrentlyStudy');
        //if ($education->is_currently_study == true) {
            if ($education->save()) {
                return $this->sendResponse(null, 'Education created successfully.');
            }
        {
            return $this->sendError('Education created failed.');
    }
}

    public function show($id)
    {
        if ($education = Education::find($id)) {
            return $this->sendResponse(new EducationResource($education), 'Education retrieved successfully.');
        }
        return $this->sendError('Education not found');
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        $validation = self::validateFields($request);
        $validator = Validator::make($input, $validation['required_fields'], $validation['validation_messages']);
        
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $education = Education::findOrfail($id);
        $education->user_id      = $request->input('userId');
        $education->school       = $request->input('school');
        $education->course_name  = $request->input('courseName');
        $education->field_of_study     = $request->input('fieldOfStudy');
        $education->grade     = $request->input('grade');
        $education->activity_and_society     = $request->input('activityAndSociety');
        $education->description     = $request->input('description');
        $education->start_date   = $request->input('startDate');
        $education->end_date     = $request->input('endDate');
        $education->is_currently_study  = $request->input('isCurrentlyStudy');
        if ($education->save()) {
            return $this->sendResponse(null, 'Education updated successfully.');
        }
        return $this->sendError('Education update failed.');
        //  else {
        //     return $this->sendError('ID does not exist.');
    }

    public function destroy($id)
    {
        $education = Education::find($id);
        if ($education) {
            $education->delete();
            return $this->sendResponse(null, 'Education deleted successfully.');
        } else {
            return $this->sendError('Education is not found.');
        }
    }

    public function getEducationByUserId($id)
    {
        $user = User::find($id);
        if ($user) {
            $educations = $user->education()->orderBy('start_date', 'DESC')->get();
            //dd($educations);
            if (count($educations) != 0) {
                return $this->sendResponse(EducationResource::collection($educations), 'Education retrieved successfully.');
            }
            return $this->sendResponse(EducationResource::collection($educations), 'Education details Not found');
        }

        return $this->sendError('User Not found');
    }
}
