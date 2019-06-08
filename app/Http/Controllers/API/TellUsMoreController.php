<?php

namespace App\Http\Controllers\API;
use App\TellUsMore;
use Illuminate\Http\Request;
use Response;
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
            return Response::json([
                'error' => e.getMessage()
            ],400);
        }
        return Response::json([
            'tum_data' => $data,
            'message' => 'success'
        ],200);
    }

    /**
     * Display with pagination
     * 
     * @return Response
     */
    public function show(Request $request,$id){

        try{
            $data = TellUsMore::select('id','tum_code','tum_name')->whereNull('user_id')->where('tum_code','=',$id)->get();
        }catch(Exception $e){
            return Response::json([
                'error' => e.getMessage()
            ],400);
        }

        return Response::json([
            'tum_data' => $data,
            'message' => 'success'
        ],200);
    }

    
}
