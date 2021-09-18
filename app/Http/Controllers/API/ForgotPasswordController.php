<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Models\User;

use App\Http\Controllers\API\ApiBaseController as ApiBaseController;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;


class ForgotPasswordController extends ApiBaseController
{
    public function forgot(Request $request) {
      

        $input = $request->all();
   
        $validator = Validator::make($input, [
            'email' => 'required',
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        
        if(User::where('email',$input)->doesntExist())
        {
        return $this->sendResponse(null,' User doesnot exists.');
        }
        $response =  Password::sendResetLink($input);
            if($response == Password::RESET_LINK_SENT){
                return $this->sendResponse(null,'Your request sucessfully send, please check your mail');
            }else{
                return $this->sendResponse(null,' wrong email.');
            }

    }

    public function reset(Request $request) {
        $input = $request->all();
        $validator = Validator::make($input, [
            'token' => 'required',
            'email' => 'required|email',
            'password'              => 'required|min:6|max:20',
                //'passwordConfirmation' => 'required|same:password',
            ]);
            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());       
            }
            $response = Password::reset($input, function ($user, $password) {
            $user->forceFill([
            'password' => Hash::make($password)
            ])->save();
            event(new PasswordReset($user));
            });
            if($response == Password::PASSWORD_RESET){
                return $this->sendResponse(null,' password reset successfully.');
            }else{
                return $this->sendResponse(null, "Email could not be sent to this email address");
            }
   
            }
}
