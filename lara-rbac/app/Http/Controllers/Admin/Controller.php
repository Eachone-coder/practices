<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as RoutingController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends RoutingController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
