<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\Response;

class APIBaseController extends Controller
{
	public function sendError($error, $errorMessage = [], $code = 400)
	{
		if(!empty($errorMessage)){
			$response['data'] = $errorMessage;
		}
		$response['success']='0';
		$response['message']=$error;
		return response()->json($response,	$code);
	}
}