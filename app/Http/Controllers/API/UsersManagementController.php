<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\API\ApiBaseController as ApiBaseController;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use jeremykenedy\LaravelRoles\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\UserResource;
use App\Models\PersonalInfo;

class UsersManagementController extends ApiBaseController
{

    public function index()
    {
        
       $users = User::all();
        return $this->sendResponse(UserResource::collection($users), 'Users retrieved successfully.');
    }
    
    public function store(Request $request)
    {
        $input = $request->all();
      
        $validator = Validator::make($input, [
            'firstName'            => 'required',
            'lastName'             => 'required',
            'email'                 => 'required|unique:users',
            'password'              => 'required|min:6|max:20|confirmed',
            'password_confirmation' => 'required|same:password',
            'roleId'                  => 'required',
        ],
    [
        'firstName.required'=>'FirstName is required',
        'lastName.required'=>'LastName is required,',
        'email.required'=>'Email is required'
    ]);
            
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $user =new User;
        $user->email             = $request->input('email');
        $user->password         = bcrypt($request->input('password'));
        
        if($user->save()){
            $user->attachRole($request->input('roleId'));
            PersonalInfo::create([
                'user_id'    =>$user->id,
                'first_name'        => $request->input('firstName'),
                'last_name'        => $request->input('lastName')]);
            return $this->sendResponseNoData('Users details created successfully.');
        }
 } 
            
   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $user = User::find($id);
        dd($user);
        // if (is_null($user)) {
        //     return $this->sendError('User not found.');
        // }
        return $this->sendResponse(new UserResource($user), 'User details  retrieved successfully.');
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // return $this->sendResponse(new AllUserDetails($user), 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $User=User::find($id);
        if($User){
            if ($User->delete()) {
                return $this->sendResponse(null,'User deleted successfully.');
            }
            return $this->sendError('User not deleted.');
        }
        return $this->sendError('User not found.'); 
    }

    public function getUsersbyRole($roleName){
        if($roleName === 'Candidate'){
            $users=User::whereHas(
                'roles', function($q){
                    $q->where('name', 'Candidate');
                })->orderBy('id', 'desc')->paginate(config('ipartnerconstants.paginateSize'));
        return $this->sendResponse(UserResource::collection($users), 'Role Users retrieved successfully.');
        }
    }

    //applicant search
    public function search(Request $request,$roleName)
    {
        $searchTerm = $request->input("userSearch");

        $searchRules = [
            'userSearch' => 'required|string|max:255',
        ];
        $searchMessages = [
            'userSearch.required' => 'Search term is required',
            'userSearch.string'   => 'Search term has invalid characters',
            'userSearch.max'      => 'Search term has too many characters - 50 allowed',
        ];
  
        $validator = Validator::make($request->all(), $searchRules, $searchMessages);
  
        if ($validator->fails()) 
            {
                return $this->sendError('Validation Error.', $validator->errors());
        } 
        if($roleName=='Candidate'){
            $candidates = User::whereHas('roles', function($q){
                $q->where('name','Candidate');
                });
           
            return $this->sendResponse(UserResource::collection(self::userSearch($candidates,$searchTerm)), 'Users retrieved successfully.');
        }
        return $this->sendError('role is not found');
        
    }
    public function userSearch($users,$searchTerm)
    {
        return $users->WhereHas('personalInfo',function($q)use($searchTerm) {
              $q->where('first_name','like', $searchTerm.'%' );
          })
          ->orwhere('email', 'like', $searchTerm.'%')
          ->orWhereHas('personalInfo',function($q)use($searchTerm) {
              $q->where('last_name','like', $searchTerm.'%' );
          })->get(); 
        
    }
}
