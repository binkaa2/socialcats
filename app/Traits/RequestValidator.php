<?php

namespace App\Traits;

use Illuminate\Support\Facades\Validator;

trait RequestValidator {
    use JsonResponse;

    function customValidate($request, $rule = [], $message = []) {
        $validate_result = Validator::make($request->all(), $rule, $message);
        return $validate_result;
    }

    function sendResponseInvalidParams($validate_result) {
        return $this->sendResponse(false,
            'Parameter incompatibility : ' . $validate_result->errors()->first(),
            null, ResponseCode::EXPECT_PARAM);
    }
}
