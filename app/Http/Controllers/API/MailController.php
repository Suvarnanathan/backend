<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\ApiBaseController as ApiBaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Mail;
use PDF;
use App\Models\User;

use function PHPUnit\Framework\callback;

class MailController extends ApiBaseController
{
    public function attachment_email(Request $request) {

      $validator = Validator::make($request->all(), [
         'candidatesId' => 'required',
         'recipients' => 'required',
         'subject'=>'required',
         'body'=>'required',
         'name'=>'required'
      ],
      [
            'candidatesId.required'=>'Candidate(s) required',
            'recipients'=>'Recipient(s) mail address required',
            'subject.required'=>'Please enter  subject of the mail',
            'body.required'=>'Please enter  message of the mail',
            'name.required'=>'Please enter  name'
      ]);

      if($validator->fails()){
         return $this->sendError('Validation Error.', $validator->errors());       
      }
      try{
         $subject = $request->input('subject');
         $to = $request->input('recipients');
         $cc = $request->input('cc');
         $name = $request->input('name');
         $candidateIds = $request->input('candidatesId');
         Mail::html($request->input('body'),function($message) use ($candidateIds,$subject,$to,$cc,$name){
                     $message->to($to)
                     ->subject($subject)
                     ->from('primetechno28@gmail.com',$name)
                     ->cc($cc);

                     foreach($candidateIds as $candidateId){
                        $results = $this->pdfGenerator($candidateId);
                        $message->attachData($results['pdfOutput'], $results['name'].'.pdf');
                     }
         });

      }

      catch(\Exception $e){
      return $this->sendError('mailing error',$e);
      }

      return $this->sendResponse(null,'Email Sent successfully.');
     }


     public function pdfGenerator($candidateId){

      $user=User::where('id',$candidateId)->with(['personalInfo','skills','jobExperience.jobSubCategory',
                                          'jobExperience.country','certificates','licences',
                                          'education'=> function ($query) {
                                             $query->orderBy('start_date', 'desc');
                                             }
                                       ])->first();
      if($user->personalInfo->profileImage){

         $type = pathinfo($user->personalInfo->profileImage->public_path, PATHINFO_EXTENSION);
         $image = 'data:image/' . $type . ';base64,' . base64_encode(file_get_contents($user->personalInfo->profileImage->public_path));

      }                                      
      else{
         $image = 'data:image/png;base64,' . base64_encode(file_get_contents('Images/profile.png'));

      }
      $bgimage = 'data:image/png;base64,' . base64_encode(file_get_contents('Images/background.png'));

      $pdf = PDF::loadView('generate-pdf',['user'=>$user,'image'=>$image,'bgimage'=>$bgimage]);

      $pdf->setPaper("A4", "portrait");
      // return view('generate-pdf',['user'=>$user,'image'=>$image]);
      // return $pdf->download('resume.pdf');
      return ['pdfOutput'=>$pdf->stream(),'name'=>$user->personalInfo->first_name." ".$user->personalInfo->last_name];
   }

      
}


