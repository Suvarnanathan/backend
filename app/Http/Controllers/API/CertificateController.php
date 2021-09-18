<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\API\ApiBaseController as ApiBaseController;
use Illuminate\Http\Request;
use App\Models\Certificate;
use App\Models\User;
use Validator;
use App\Http\Resources\Certificate as CertificateResource;
class CertificateController extends ApiBaseController
{
    //store certificate
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'userId'            => 'required',
            'name'              => 'required',
            'issuedOrganization'=> 'required',
            'startDate'         => 'required',
            'endDate'           => 'required|date|after_or_equal:startDate',
        ],
        [
            'name.required'=>'Certificate Name is required',
            'issuedOrganization.required'=>'Issued Organization is required',
            'startDate.required'=>'Start Date is required',
            'endDate.required'=>'End Date is required'

        ]
    );
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $certificate=new Certificate;
        $certificate->user_id               = $request->input('userId');
        $certificate->name                  = $request->input('name');
        $certificate->issued_organization   = $request->input('issuedOrganization');
        $certificate->start_date            = $request->input('startDate');
        $certificate->end_date              = $request->input('endDate');
        if($certificate->save()){
            return $this->sendResponse(['certificateId'=>$certificate->id],'Certificate  created successfully');
        }
        return $this->sendError('Certificate  not created.');
    }
    
    //update certificate
    public function update(Request $request,$certificateId)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'userId'            => 'required',
            'name'              => 'required',
            'issuedOrganization'=> 'required',
            'startDate'         => 'required',
            'endDate'           => 'required|date|after_or_equal:startDate'
        ],
        [
            'name.required'=>'Certificate Name is required',
            'issuedOrganization.required'=>'Issued Organization is required',
            'startDate.required'=>'Start Date is required',
            'endDate.required'=>'End Date is required'

        ]
    );
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $certificate=Certificate::find($certificateId);
        if($certificate){
            $certificate->user_id               = $request->input('userId');
            $certificate->name                  = $request->input('name');
            $certificate->issued_organization   = $request->input('issuedOrganization');
            $certificate->start_date            = $request->input('startDate');
            $certificate->end_date              = $request->input('endDate');
            if($certificate->save()){
                return $this->sendResponse(null,'Certificate  updated successfully');
            };
        }
        return $this->sendError('Certificate not found.');
    }

    //delete certificate
    public function destroy($certificateId)
    {
        $certificate=Certificate::find($certificateId);
        if($certificate){
            $certificateImage=$certificate->certificateImage->first();
            unlink($certificateImage->public_path);
            unlink($certificateImage->thumb_path);
            $certificateImage->delete();
            if ($certificate->delete()) {
                return $this->sendResponse(null,'Certificate deleted successfully.');
            }
            return $this->sendError('Certificate not deleted.');
        
        }
        return $this->sendError('Certificate not deleted.'); 
    }
     //get certificate details by user id
    public function getCertificateByUserId($userId)
    {
        $user=User::find($userId);
        if($user->certificates){
            return $this->sendResponse(CertificateResource::collection($user->certificates), 'User certificates retrieved successfully.');
        }        
        return $this->sendError('User certificates not  retrieved');
    }

}
