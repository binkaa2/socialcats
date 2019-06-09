<?php

namespace App\Http\Controllers\API;
use App\TellUsMore;
use Illuminate\Http\Request;
use Response;
use App\Traits\ResponseCode;
use App\Http\Controllers\Controller;
class TellUsMoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $data = TellUsMore::select('id','tum_code','tum_name','user_id')->get();
        }catch(Exception $e){
            return $this->sendResponse(false, 'Retrive tell us more data fail!', null, ResponseCode::SERVER_ERROR);
        }
        return $this->sendResponse(true,'Retrive tell us more data successfully!',$data);
    }

    /**
     * Display with tell_us_more code = $id
     * 
     * @param $id
     * @return Response
     */
    public function show(Request $request,$id){

        try{
            $data = TellUsMore::select('id','tum_code','tum_name')->whereNull('user_id')->where('tum_code','=',$id)->get();
        }catch(Exception $e){
            return $this->sendResponse(false, 'Retrive tell us more data fail!', null, ResponseCode::SERVER_ERROR);
        }

        return $this->sendResponse(true,'Retrive tell us more data successfully!',$data);
    }

}
