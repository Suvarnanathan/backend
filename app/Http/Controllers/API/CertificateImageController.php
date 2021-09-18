<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Models\CertificateImage;
use App\Models\Certificate;
use Validator;
use File;
use Image;
use View;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\API\ApiBaseController as ApiBaseController;
use App\Http\Resources\CertificateImage as CertificateImageResource;
class CertificateImageController extends ApiBaseController
{
    // showing all certificates
    public function index()
    {
        $certificateImages = CertificateImage::all();
        if ($certificateImages->isNotEmpty()) {
            return $this->sendResponse(CertificateImageResource::collection($certificateImages), 'Certificate images retrieved successfully.');
           }
           return $this->sendResponse(CertificateImageResource::collection($certificateImages), 'Certificate images not found.');
    }
    public function upload(Request $request,$certificateId)
    {
        $certificate = Certificate::find($certificateId);
        $certificateImage = $certificate->certificateImage->first();
        if($certificateImage){
            self::destroy($certificateImage->id);
        }
        if($request->hasFile('image')){
            $certificateImage = $request->image;
            // dd($request);
                //generate thumb image
                $certificateThumbImage = Image::make($certificateImage);
                //generate random string for image name
                $random_string = md5(microtime());
                //make image names
                $certificateImageName       = $random_string .'.'. $certificateImage->getClientOriginalExtension();
                $certificateThumbImageName  = $random_string.'.'.$certificateImage->getClientOriginalExtension();
                //save path
                $save_path          = storage_path('app/public') . '/CertificateImages/' . $certificateId;
                $save_path_thumb    = storage_path('app/public') . '/CertificateImages/' . $certificateId.'/thumb/';
                //path
                $path               = $save_path . $certificateImageName;
                $path_thumb         = $save_path_thumb . $certificateThumbImageName;
                //public path
                $public_path        = 'storage/CertificateImages/' . $certificateId . '/' . $certificateImageName;
                $public_path_thumb  = 'storage/CertificateImages/' . $certificateId.'/thumb/'.$certificateThumbImageName;
                // Make  a folder for questionimages  and set permissions
                File::makeDirectory($save_path, $mode = 0755, true, true);
                File::makeDirectory($save_path_thumb, $mode = 0755, true, true);
                //resize original image
                $certificateThumbImage->resize(150,150);
                // Save the file to the server
                $certificateImage->move($save_path, $certificateImageName);
                $certificateThumbImage->save($path_thumb);
                //save image in question related image table
                $certificateImage = new CertificateImage;
                $certificateImage->certificate_id        = $certificateId;
                $certificateImage->image_name            = $certificateImageName;
                $certificateImage->public_path           = $public_path;
                $certificateImage->thumb_path            = $public_path_thumb;
                if($certificateImage->save()){
                    return $this->sendResponse(asset($certificateImage->public_path),'Certificate  created successfully');;
                }
                return $this->sendError(null,'Certificate  not created');;
            }
        
    }
    //get certificate image by id
    public function show($certificateId)
    {
        $certificate = Certificate::find($certificateId);
        $certificateImages = $certificate->certificateImage;
        if ($certificateImages) {
            return $this->sendResponse(CertificateImageResource::collection($certificateImages),'Certificate image retrieved successfully.');
        }
        return $this->sendError('Certificate image not found.');
    }
    
    //delete certifitae images
    public function destroy($certificateImageId)
    {
        $certificateImage=CertificateImage::find($certificateImageId);
        unlink($certificateImage->public_path);
        unlink($certificateImage->thumb_path);
        if ($certificateImage->delete()) {
            return $this->sendResponse(null,'Certificate image deleted successfully.');
        }
        return $this->sendError('Certificate image not deleted.');
        
    }
}
