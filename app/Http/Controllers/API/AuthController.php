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
            return response()->json([
                'error'=>$validator->errors()
            ],400);
        }

        $input = $request->all();
        $password = $input['password'];
        $input['password'] = bcrypt($input['password']);

        try {
            $user = User::create($input);
            forEach($request->tums as $tum){
                $tell_us_more = TellUsMore::create([
                    "user_id" => $user->id,
                    "tum_code" => $tum['tum_code'],
                    "tum_name" => $tum['tum_name']
                ]);
            }
        } catch (Exception $exception) {
            return response()->json([
                'error'=>$exception->getMessage()
            ],200);
        }
        return response()->json([
            'message' => 'Successfully creating new users'
        ],200);

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
            return response()->json([
                'error' => 'email or password incorrect!'
            ],401);
        }
        $user = Auth::user(); 
        $tokenResult = $user->createToken('gapmash-token');
        $token = $tokenResult->token;
        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
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
            return response()->json([
                "error" => "user not found!"
            ],404);
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
        return response()->json([
            'message' => 'Successfully logged out'
        ],200);
    }
}
