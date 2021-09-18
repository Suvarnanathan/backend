<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\ApiBaseController as ApiBaseController;
use App\Models\PersonalInfo;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;
use App\Http\Resources\PersonalInfo as PersonalInfoResource;

class PersonalInfoController extends ApiBaseController
{
    public function index()
    {
        $personalinfos = PersonalInfo::all();
        if ($personalinfos->isNotEmpty()) {
            return $this->sendResponse(PersonalInfoResource::collection($personalinfos), 'personalinfos retrieved successfully.');
        }
        return $this->sendResponse(PersonalInfoResource::collection($personalinfos), 'personalinfos not found.');
    }

    public function store(Request $request)
    {

        $input = $request->all();

        $validator = Validator::make($input, [
            'userId'     => 'required',
            'countryId'  => 'required',
            'city'       => 'required',
            // 'streetName' => 'required',
            // 'postalCode' => 'required',
            'gender'     => 'required',
            'dob'        => 'required',
            'firstName'            => 'required',
            'lastName'             => 'required',

        ], [
            'countryId.required' => 'Country name is required.',
             'city.required' => 'City name is required.',
            // 'streetName.required' => 'Street name is required.',
            // 'postalCode.required' => 'Postal code is required.',
            'gender.required' => 'Gender field is required.',
            'dob.required' => 'Date of birth is required.',
            'firstName.required'=>'FirstName is required',
            'lastName.required'=>'LastName is required',

        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $personalInfo = new PersonalInfo();
        $personalInfo->user_id      = $request->input('userId');
        $personalInfo->country_id   = $request->input('countryId');
        $personalInfo->first_name        = $request->input('firstName');
        $personalInfo->last_name        = $request->input('lastName');
        $personalInfo->city         = $request->input('city');
        $personalInfo->street_name  = $request->input('streetName');
        $personalInfo->postal_code  = $request->input('postalCode');
        $personalInfo->gender       = $request->input('gender');
        $personalInfo->dob          = $request->input('dob');
        $personalInfo->about        = $request->input('about');
        $personalInfo->has_profile        = $request->input('hasProfile');

        if ($personalInfo->save()) {
            return $this->sendResponse(null, 'Personal info created successfully.');
        } else {
            return $this->sendError('Personal info create faild.');
        }
    }

    public function show($id)
    {
        if ($personalinfo = PersonalInfo::find($id)) {
            return $this->sendResponse(new PersonalInfoResource($personalinfo), 'personalinfo retrieved successfully.');
        }
        return $this->sendError('personalinfo not found');
    }

    public function update(Request $request, $id)
    {

        $personalInfo = PersonalInfo::find($id);
        if ($personalInfo) {
            $validator = Validator::make(
                $request->all(),
                [
                    'userId'     => 'required',
                    'countryId'  => 'required',
                    'city'       => 'required',
                    'firstName'            => 'required',
                    'lastName'             => 'required',
                    // 'streetName' => 'required',
                    // 'postalCode' => 'required',
                    'gender'     => 'required',
                    'dob'        => 'required',
                ],
                [
                    'countryId.required' => 'Country name is required.',
                    'city.required' => 'City name is required.',
                    'firstName.required'=>'FirstName is required',
                    'lastName.required'=>'LastName is required',
                    // 'streetName.required' => 'Street name is required.',
                    // 'postalCode.required' => 'Postal code is required.',
                    'gender.required' => 'Gender field is required.',
                    'dob.required' => 'Date of birth is required.',
                ]
            );

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            };

            $personalInfo->user_id      = $request->input('userId');
            $personalInfo->country_id   = $request->input('countryId');
            $personalInfo->first_name   = $request->input('firstName');
            $personalInfo->last_name    = $request->input('lastName');
            $personalInfo->city         = $request->input('city');
            $personalInfo->street_name  = $request->input('streetName');
            $personalInfo->postal_code  = $request->input('postalCode');
            $personalInfo->gender       = $request->input('gender');
            $personalInfo->dob          = $request->input('dob');
            //$personalInfo->has_profile  = $request->input('hasProfile');

            if ($personalInfo->save()) {
                return $this->sendResponse(null, 'PersonalInfo updated successfully.');
            }
            return $this->sendError('PersonalInfo update failed.');
        } 
        else {
            return $this->sendError('ID doesnot exist.');
        }
    }
    public function destroy($id)
    {
        $personalInfo = PersonalInfo::find($id);
        if ($personalInfo) {
            $personalInfo->delete();
            return $this->sendResponse(null, 'Personal Info details  deleted successfully');
        } else {
            return $this->sendError('Personal Info is not found');
        }
    }

    public function getPersonalInfoByUserId($id)
    {
        $user = User::find($id);
        if ($user) {
            return $this->sendResponse(new PersonalInfoResource($user->personalinfo), 'personalinfo retrieved successfully.');
        }
        return $this->sendError('User not found');
    }
    public function updatAboutByUserId(Request $request, $userId)
    {
        $personalInfo = PersonalInfo::find($userId);
        if ($personalInfo) {
            $personalInfo->about        = $request->input('about');
            if ($personalInfo->update()) {
                return $this->sendResponse(null, 'PersonalInfo About updated successfully.');
            }
            return $this->sendError('PersonalInfo About update failed.');
        } else {
            return $this->sendError('ID doesnot exist.');
        }
    }
}
