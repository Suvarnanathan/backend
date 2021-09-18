<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

class ApiBaseController extends Controller
{
    public function sendResponse($result, $message)
    {
        if($result!=null){
            $response = [
                'success' => true,
                'results'    => $result,
                'message' => $message,
            ];
            
        }
        else{
            $response = [
                'success' => true,
                'message' => $message,
            ];
        }
            return response()->json($response, 200);
    }

    public function sendError($error, $errorMessages = [], $code = 400)
    {
    	$response = [
            'success' => false,
            'message' => $error,
        ];
        if(!empty($errorMessages)){
            $response['error'] = $errorMessages;
        }
        return response()->json($response, $code);
    }
}
