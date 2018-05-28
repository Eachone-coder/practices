<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class CommonController extends Controller
{
    public function uploads(){
        $file=Input::file('file');
        if($file->isValid()){
            $extension=$file->getClientOriginalExtension();
            $newName=date('YmdHis').mt_rand(100,999).'.'.$extension;
            $path=$file->move(base_path().'\uploads',$newName);
            $filePath='uploads/'.$newName;
            return $filePath;
        }
    }
}
