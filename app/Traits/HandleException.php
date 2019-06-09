<?php
/**
 * Credited to PT Hung
 */
namespace App\Traits;
trait HandleException{
    use JsonResponse;
    function responseExceptionError($message, $type){
        return $this->sendResponse(false, $message, null, $type);
    }
}
