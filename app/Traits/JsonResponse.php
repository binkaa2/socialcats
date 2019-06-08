<?php

namespace App\Traits;
trait JsonResponse {


    public function errorFromCode($code) {
        switch ($code) {
            case ResponseCode::UNAUTHORIZED :
                return [
                    'errorType' => 'unauthorized',
                    'responseCode' => 401
                ];
            case ResponseCode::BAD_REQUEST :
                return [
                    'errorType' => 'bad_request',
                    'responseCode' => 400
                ];
            case ResponseCode::EXPECT_PARAM :
                return [
                    'errorType' => 'expect_param',
                    'responseCode' => 400
                ];
            case ResponseCode::SERVER_ERROR :
                return [
                    'errorType' => 'server_error',
                    'responseCode' => 500
                ];
            case ResponseCode::DB_ERROR :
                return [
                    'errorType' => 'server_error',
                    'responseCode' => 500
                ];
            case ResponseCode::NOT_FOUND :
                return [
                    'errorType' => 'not_found',
                    'responseCode' => 404
                ];
            case ResponseCode::FORBIDDEN :
                return [
                    'errorType' => 'forbidden',
                    'responseCode' => 403
                ];
            case ResponseCode::METHOD_NOT_ALLOWED :
                return [
                    'errorType' => 'method_not_allowed',
                    'responseCode' => 405
                ];
            case ResponseCode::REQUEST_TIME_OUT :
                return [
                    'errorType' => 'request_time_out',
                    'responseCode' => 408
                ];
            case ResponseCode::GRANT_TOKEN_FAIL :
                return [
                    'errorType' => 'grant_token_fail',
                    'responseCode' => 500
                ];
            case ResponseCode::UN_AUTHENTICATION :
                return [
                    'errorType' => 'un_authentication',
                    'responseCode' => 401
                ];
            case ResponseCode::SERVICE_UNAVAILABLE :
                return [
                    'errorType' => 'service_unavailable',
                    'responseCode' => 503
                ];
            default :
                return [
                    'errorType' => 'server_error',
                    'responseCode' => 500
                ];

        }
    }

    /**
     * return Json object for response
     * @param $status
     * @param $message
     * @param null $data
     * @param null $error
     * @return array
     */
    public function ResponseJsonObject($status, $message = 'None', $data = null, $error = null) {

        if ($status == true)
            return [
                'success' => true,
                'data' => $data,
                'message' => $message
            ];
        else
            return [
                'success' => false,
                'error' => $error,
                'message' => $message
            ];
    }

    /**
     * send response
     * @param $status
     * @param string $message
     * @param null $data
     * @param null $errorCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendResponse($status, $message = 'None', $data = null, $errorCode = null) {
        if ($status == true)
            return response()->json($this->ResponseJsonObject($status, $message, $data, null), 200);
        else {
            $error = $this->errorFromCode($errorCode);
//            dd($error);
            return response()->json($this->ResponseJsonObject($status, $message, null, $error['errorType']), $error['responseCode']);
        }
    }
}
