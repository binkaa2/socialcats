<?php

namespace App\Http\Controllers\Backend;
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        //$this->validate($request, ['name' => 'required']);
        
        $TellUsMore = new TellUsMore;
        $TellUsMore->user_id = '1';
        $TellUsMore->tum_code = $request->tum_code;
        $TellUsMore->tum_name = $request->tum_name;
        $Categories->save();
        
        return TellUsMore()->json([
            "message" => "insert successful"
        ],200);
    }

}
