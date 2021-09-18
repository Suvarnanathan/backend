<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\ApiBaseController as ApiBaseController;
use Illuminate\Http\Request;
use Validator;
use Auth;
use App\Models\User;
use App\Helpers\AuthRoleClass;
use App\Models\PersonalInfo;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;

class RegisterController extends ApiBaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'firstName'            => 'required',
                'lastName'             => 'required',
                'email'                 => 'required|unique:users',
                'password'              => 'required|min:6|max:20|confirmed',
                'password_confirmation' => 'required|same:password',
                'roleId'                  => 'required',
            ],
            [
                'firstName.required' => 'FirstName is required',
                'lastName.required' => 'LastName is required',
                'email.required' => 'Email is required'
            ]
        );

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $user = new User;
        $user->email             = $request->input('email');
        $user->password         = bcrypt($request->input('password'));

        if ($user->save()) {
            PersonalInfo::create([
                'user_id'           =>  $user->id,
                'first_name'        => $request->input('firstName'),
                'last_name'        => $request->input('lastName')
            ]);
            $user->attachRole($request->input('roleId'));
            $success['token'] =  $user->createToken('MyApp')->accessToken;
            $success['id'] =  $user->id;
            $success['name'] =  $user->name;
            return $this->sendResponse($success, 'User register successfully.');
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email'                 => 'required',
                'password'              => 'required'
            ],
            [
                'password.required' => 'Please enter password',
                'email.required' => 'Please enter email'
            ]
        );
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')->accessToken;
            $success['id'] =  $user->id;
            $success['name'] =  $user->name;
            $success['role'] =  AuthRoleClass::getAuthRole();
            return $this->sendResponse($success, 'User login successfully.');
        } else {
            return $this->sendError(['Please check your username or password']);
        }
    }
    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();
        return $this->sendResponse(null, 'You have been successfully logged out!');
    }
    public function changePassword(Request $request)
    {
        $commonRequiredField = [
            'currentPassword'      => ['required', new MatchOldPassword],
            'newPassword'              => 'required|min:6|max:20',
            'confirmPassword'       => 'required|same:newPassword',
        ];

        $commonValidMessage = [
            'currentPassword.required' => 'Please enter current password',
            'password.required' => 'Please enter password',
            'confirmPassword.required' => 'Please enter confirm password',
        ];
        $validator = Validator::make($request->all(), $commonRequiredField, $commonValidMessage);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        if (Hash::check($request->input('currentPassword'), Auth::user()->password)) {
            User::find(auth()->user()->id)->update(['password' => Hash::make($request->newPassword)]);
            return $this->sendResponse(null, 'You have been successfully change password!');
        }
    }
}
