<?php

namespace App\Http\Controllers;

use App\Traits\HandleException;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Traits\RequestValidator;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    use RequestValidator;
}
