<?php
/**
 * Credited to PT Hung
 */
namespace App\Traits;
class ResponseCode{
    public const UNAUTHORIZED = 10000;
    public const BAD_REQUEST = 10001;
    public const EXPECT_PARAM = 10002;
    public const SERVER_ERROR = 10003;
    public const DB_ERROR = 10004;
    public const NOT_FOUND = 10005;
    public const FORBIDDEN = 10006;
    public const METHOD_NOT_ALLOWED = 10007;
    public const REQUEST_TIME_OUT = 10008;
    public const GRANT_TOKEN_FAIL = 10009;
    public const UN_AUTHENTICATION = 10010;
    public const SERVICE_UNAVAILABLE = 10011;
}
