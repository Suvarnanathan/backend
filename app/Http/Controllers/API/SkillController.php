<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Support\Str;
use App\Http\Controllers\API\ApiBaseController as ApiBaseController;
use App\Http\Resources\Skill as SkillResource;
use App\Http\Resources\UserSkills as UserSkillsResource;

use Illuminate\Support\Facades\Validator;

class SkillController extends ApiBaseController
{
   
    //showing all the skills
   public function index()
    {
       $skills = Skill::all();
        if(count($skills)!=0){
        return $this->sendResponse(SkillResource::collection($skills), 'Skills retrieved successfully.');
        }
            return $this->sendResponse(SkillResource::collection($skills), 'Skills are not found');

    }

   //create new skill
    public function store(Request $request)
    {
       $input = $request->all();
  
       $validator = Validator::make($input, [
           'name' => 'required'
        ]);

       if($validator->fails()){
           return $this->sendError('Validation Error.', $validator->errors());       
        }
           $skill = new Skill();
           $skill->name=$request->input('name');
           $skill->slug=Str::slug($request->input('name'),'-');
           if($skill->save()){
        return $this->sendResponse(null,'Skill created successfully.');
           }
               return $this->sendError('skill create failed');
    } 
  
   //showing skill
    public function show($id)
    {
      $skill = Skill::find($id);

      if($skill){
        return $this->sendResponse(new SkillResource($skill), 'Skill retrieved successfully.');
      }

      return $this->sendError('Skill is not found.');

    }

    //update skill details
    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(),
        [
            'name'     => 'required' 
        ]
        );

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        } 

        $skill = Skill::findOrFail($id);
        $skill->name = $request->input('name');
        $skill->slug = Str::slug($request->input('name'),'-');

        if($skill->save()){
            return $this->sendResponse(null, 'Skill updated successfully.');
        }
            return $this->sendError('skill update failed');

    }
 
    //delete skill
    public function destroy($id)
    {
        $skill=Skill::find($id);

        if($skill){
            $skill->delete();
            return $this->sendResponse(null,'Skill deleted successfully.');
        }
            return $this->sendError('Skill is not found');
    } 
    public function getSkillsByUserId($userId){
        $user=User::find($userId);
        if($user){
          $userSkills=$user->skills()->get();
          if(count($userSkills)!=0){
            return $this->sendResponse(UserSkillsResource::collection($userSkills), 'user skills  retrieved successfully.');
        }
        return $this->sendResponse(UserSkillsResource::collection($userSkills), 'user skills are not found.');
      
      } 
        return $this->sendError('user is not found');
      
    }
}
