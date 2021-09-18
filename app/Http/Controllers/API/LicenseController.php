<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\License;
use App\Models\LicenseImage;
use App\Models\User;
use Validator;
use File;
use Intervention\Image\Facades\Image;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\License as LicenseResource;
use App\Http\Resources\LicenseImage as LicenseImageResource;
use Illuminate\Validation\Rule;
use App\Http\Controllers\API\ApiBaseController as ApiBaseController;
use SebastianBergmann\Environment\Console;
// use Symfony\Component\Console\Input\Input;

class LicenseController extends ApiBaseController
{
    public function index()
    {
        $licenseImages = LicenseImage::all();
        if ($licenseImages->isNotEmpty()) {
            return $this->sendResponse(LicenseImageResource::collection($licenseImages), 'License images retrieved successfully.');
        }
        return $this->sendResponse(LicenseImageResource::collection($licenseImages), 'License images not found.');
    }

    public function upload(Request $request, $licenseId)
    {
        $license = License::find($licenseId);
        $licenseImage = $license->licenseImage->first();
        if ($licenseImage) {
            self::destroyImage($licenseImage->id);
        }
        if ($request->hasFile('image')) { //update part
            $licenseImage = $request->image;
            // dd($request);
            //generate thumb image
            $licenseThumbImage = Image::make($licenseImage);
            //generate random string for image name
            $random_string = md5(microtime());
            //make image names
            $licenseImageName       = $random_string . '.' . $licenseImage->getClientOriginalExtension();
            $licenseThumbImageName  = $random_string . '.' . $licenseImage->getClientOriginalExtension();
            //save path
            $save_path          = storage_path('app/public') . '/LicenseImages/' . $licenseId;
            $save_path_thumb    = storage_path('app/public') . '/LicenseImages/' . $licenseId . '/thumb/';
            //path
            $path               = $save_path . $licenseImageName;
            $path_thumb         = $save_path_thumb . $licenseThumbImageName;
            //public path
            $public_path        = 'storage/LicenseImages/' . $licenseId . '/' . $licenseImageName;
            $public_path_thumb  = 'storage/LicenseImages/' . $licenseId . '/thumb/' . $licenseThumbImageName;
            // Make  a folder for questionimages  and set permissions
            File::makeDirectory($save_path, $mode = 0755, true, true);
            File::makeDirectory($save_path_thumb, $mode = 0755, true, true);
            //resize original image
            $licenseThumbImage->resize(150, 150);
            // Save the file to the server
            $licenseImage->move($save_path, $licenseImageName);
            $licenseThumbImage->save($path_thumb);
            //save image in question related image table
            $licenseImage = new LicenseImage;
            $licenseImage->license_id            = $licenseId;
            $licenseImage->image_name            = $licenseImageName;
            $licenseImage->public_path           = $public_path;
            $licenseImage->thumb_path            = $public_path_thumb;
            if ($licenseImage->save()) {
                return $this->sendResponse(null, 'License  image created successfully');
            }
            return $this->sendError(null, 'License  image not created');
        }
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make(
            $input,
            [
                'userId'  => 'required',
                'title' => [
                    "required",
                    Rule::unique('licenses')->where('user_id', $request->input('userId')),
                ]
            ],
            [
                'title.required' => 'Title is required',
                'title.unique' => 'Title is already taken',
                'userId.required' => 'User id is required.'
            ]
        );
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $license = new License;
        $license->user_id        = $request->input('userId');
        $license->title          = $request->input('title');
        if ($license->save()) {
            return $this->sendResponse(['licenseId'=>$license->id], 'License  created successfully');
        }
        return $this->sendError('License  not created.');
    }

    public function show($licenseId)
    {
        $license = License::find($licenseId);
        $licenseImages = $license->licenseImage;
        if ($licenseImages) {
            return $this->sendResponse(licenseImageResource::collection($licenseImages), 'License image retrieved successfully.');
        }
        return $this->sendError('License image not found.');
    }

    public function update(Request $request, $licenseId)
    {
        $input = $request->all();
        $validator = Validator::make(
            $input,
            [
                'userId'  => 'required',
                'title'  => 'required',
            ],
            [
                'title.required' => 'Title field is required.',
                'userId.required' => 'User id is required',
            ]
        );
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $license = License::find($licenseId);
        if ($license) {
            $license->title        = $request->input('title');
            if ($license->save()) {
                return $this->sendResponse(['licenseId'=>$license->id], 'license  updated successfully');
            };
        }
        return $this->sendError('license not found.');
    }

    public function destroyImage($licenseImageId)
    {
            $licenseImage = LicenseImage::find($licenseImageId);
            unlink($licenseImage->public_path);
            unlink($licenseImage->thumb_path);
            if ($licenseImage->delete()) {
                    return $this->sendResponse(null, 'License image and deleted successfully.');
            }
        
        return $this->sendError('License image not found.');
        
        // return $this->sendResponse(null, 'License deleted successfully.');
    }

    public function destroyLicense($licenseId)
    {
        $license=license::find($licenseId);
        if($license){
            // dd($license);
            $licenseImage = $license->licenseImage()->get()->first();  
            if($licenseImage){     
                unlink($licenseImage->public_path);
                unlink($licenseImage->thumb_path);
                if ($licenseImage->delete() ) {
                    if( $license->delete()){
                        return $this->sendResponse(null, 'License image and license deleted successfully.');
                    }
                }
            }
            else{
                return $this->sendError('License image not deleted.');
            }
            // if ($license->delete()) {
            //     return $this->sendResponse(null,'license deleted successfully.');
            // }
            return $this->sendError('license not deleted.');
        }
        return $this->sendError('license not deleted.'); 
        
    }

    public function getLicenseByUserId($userid)
    {
        $user = User::find($userid);
        if ($user) {
            $licenses = $user->licences;
            if (count($licenses) != 0) {
                return $this->sendResponse(LicenseResource::collection($licenses), 'license retrieved successfully.');
            }
            return $this->sendResponse(null, 'licenses not found.');
        }
        return $this->sendError('User not found.');
    }
}
