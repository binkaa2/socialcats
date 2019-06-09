<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
class DashboardController extends Controller
{
    public function __construct(){

    }

    /**
     * Retrive index
     * @return index cms page
     */
    public function index(Request $request){
        $user = User::all()->count();
        return view('cms.index',['user'=>$user]);
    }
}
