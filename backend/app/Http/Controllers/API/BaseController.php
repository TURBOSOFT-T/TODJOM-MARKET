<?php

namespace App\Http\Controllers\API;

use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    
    public function getResponse($data, $message)
    {
    	$response = [
            'success' => true,
            'message' => $message,
            'data' => $data
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    
    public function sendResponse($data, $message)
    {
    	$response = [
            'success' => true,
            'message' => $message,
            'data'    => $data,
        ];
        return response()->json($response, Response::HTTP_CREATED);
    }

  
    public function sendError($message)
    {
    	$response = [
            'success' => false,
            'message' => $message,
        ];
        return response()->json($response, Response::HTTP_UNAUTHORIZED);
    }

   
    public function getError($message)
    {
    	$response = [
            'success' => false,
            'message' =>  $message
        ];
        return response()->json($response, Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}