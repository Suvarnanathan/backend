<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Skill;
use App\Models\User;
use App\Http\Controllers\API\ApiBaseController as ApiBaseController;
use Illuminate\Support\Facades\Validator;

class SkillUserController extends ApiBaseController
{
    // create/update skill_user
    public function store(Request $request)
    {
       $input = $request->all();
       $validator = Validator::make($input, [
           'userId' => 'required',
           'skillIds'=>'required'
       ],
    [
        'skillIds.required'=>'Please Select Skills'
    ]);

       if($validator->fails()){
           return $this->sendError('Validation Error.', $validator->errors());       
        }
        
        User::findOrFail($request->input('userId'))->skills()->sync(Skill::find($request->input('skillIds')));

        return $this->sendResponse(null,'Skills are added successfully.');
    }

    
}
