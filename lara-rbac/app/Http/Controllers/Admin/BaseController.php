<?php

namespace App\Http\Controllers\Admin;


class BaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.admin');
    }
}
