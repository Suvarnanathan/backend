<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Models\PersonalInfo;
use App\Models\ProfileImage;
use Validator;
use File;
use Image;
use View;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\API\ApiBaseController as ApiBaseController;
class ProfileImageController extends ApiBaseController
{
    public function store(Request $request,$personalInfoId)
    {
        $PersonalInfo = PersonalInfo::find($personalInfoId);
        if($PersonalInfo->profileImage){
        $profileImage = $PersonalInfo->profileImage->first();
            self::destroy($profileImage->id);
        }
           
    if($request->hasFile('image')){
            $profileImage = $request->image;
                //generate thumb image
                $profileThumbImage = Image::make($profileImage);
                //generate random string for image name
                $random_string = md5(microtime());
                //make image names
                $profileImageName       = $random_string .'.'. $profileImage->getClientOriginalExtension();
                $profileThumbImageName  = $random_string.'.'.$profileImage->getClientOriginalExtension();
                //save path
                $save_path          = storage_path('app/public') . '/profileImages/' . $personalInfoId;
                $save_path_thumb    = storage_path('app/public') . '/profileImages/' . $personalInfoId.'/thumb/';
                //path
                $path               = $save_path . $profileImageName;
                $path_thumb         = $save_path_thumb . $profileThumbImageName;
                //public path
                $public_path        = 'storage/profileImages/' . $personalInfoId . '/' . $profileImageName;
                $public_path_thumb  = 'storage/profileImages/' . $personalInfoId.'/thumb/'.$profileThumbImageName;
                // Make  a folder for questionimages  and set permissions
                File::makeDirectory($save_path, $mode = 0755, true, true);
                File::makeDirectory($save_path_thumb, $mode = 0755, true, true);
                //resize original image
                $profileThumbImage->resize(150,150);
                // Save the file to the server
                $profileImage->move($save_path, $profileImageName);
                $profileThumbImage->save($path_thumb);
                //save image in question related image table
                $profileImage = new ProfileImage;
                $profileImage->personal_info_id        = $personalInfoId;
                $profileImage->image_name            = $profileImageName;
                $profileImage->public_path           = $public_path;
                $profileImage->thumb_path            = $public_path_thumb;
                if($profileImage->save()){
                    return $this->sendResponse(asset($profileImage->public_path),'profile  created successfully');;
                }
                return $this->sendError(null,'profile  not created');;
            }
        
    }
   
    public function destroy($profileImageId)
    {
        $profileImage=ProfileImage::find($profileImageId);
        unlink($profileImage->public_path);
        if ($profileImage->delete()) {
            return $this->sendResponse(null,'profile image deleted successfully.');
        }
        return $this->sendError('profile image not deleted.');
        
    }
}
