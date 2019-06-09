<?php

namespace App\Http\Controllers\API;

// use function bcrypt;
// use function config;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\TellUsMore;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Mockery\Exception;
// use App\Traits\Helper;
// use function now;
// use function var_dump;
// use App\Jobs\SendNotifyCreateDevice;
// use App\Traits\BaseModel;
// use App\Traits\Notify;
use App\Traits\ResponseCode;
use Carbon\Carbon;
class AuthController extends Controller
{
    //private $serve = null;
    public function __construct()
    {
       //$this->serve = config('auth.auth_server_url');
    }

    /**
     * Create user
     *
     * @param  [string] first_name
     * @param  [string] last_name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] gender
     * @param  [string] phone_number
     * @param  [array] tell_us_more question
     * @return Json
     */
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|unique:users|max:255',
            'gender' => 'required',
            'phone_number' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->sendResponse(false,$validator->errors()->first(),null,ResponseCode::EXPECT_PARAM);
        }

        $input = $request->all();
        $password = $input['password'];
        $input['password'] = bcrypt($input['password']);

        try {
            $user = User::create($input);
            if($request->tums){
                forEach($request->tums as $tum){
                    $tell_us_more = TellUsMore::create([
                        "user_id" => $user->id,
                        "tum_code" => $tum['tum_code'],
                        "tum_name" => $tum['tum_name']
                    ]);
                }
            }
            $user = Auth::user(); 
            $tokenResult = $user->createToken('gapmash-token');
            $token = $tokenResult->token;
            $token->save();
            return $this->sendResponse(true,'Sign up successfully',[
                'access_token' => $tokenResult->accessToken,
                //'refresh_token' => $tokenResult->refreshToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString()
            ]);
        } catch (Exception $exception) {
            return $this->sendResponse(false, 'Create user fails', null, ResponseCode::SERVER_ERROR);
        }
    }
    
    /**
     * Login user
     * 
     * @param [string] email
     * @param [password] password
     * 
     * @return Json
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);
        $credentials = request(['email','password']);
        if(!Auth::attempt($credentials)){
            return $this->sendResponse(false, 'Login information are incorrect', null, ResponseCode::BAD_REQUEST);
        }
        try{
            $user = Auth::user(); 
            $tokenResult = $user->createToken('gapmash-token');
            $token = $tokenResult->token;
            $token->save();
            return $this->sendResponse(true,'Login Success',[
                'access_token' => $tokenResult->accessToken,
                //'refresh_token' => $tokenResult->refreshToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString()
            ]);
        }catch(Exception $e){
            return $this->sendResponse(false, 'Retrieve access token fail', null, ResponseCode::GRANT_TOKEN_FAIL);
        }
    }

     /**
     * Get the authenticated User
     *
     * @return [json] user object with tell_us_more question
     *
     */
    public function user(Request $request)
    {
        if(!Auth::user())
            return $this->sendResponse(false, 'Get user information fail', null, ResponseCode::UNAUTHORIZED);
        $tum = Auth::user()::join('tell_us_more','users.id','=','tell_us_more.user_id')->select('tell_us_more.tum_code','tell_us_more.tum_name')->get();
        $tums['tell_us_more'] = $tum;
        $user = array_merge(json_decode(Auth::user(),true),$tums);
        return response()->json($user);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return $this->sendResponse(true, 'Successfully logged out');
    }
}
