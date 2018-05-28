<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Visitor;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class VisitorController extends CommonController{

    public function index(){
		
        $visis=Visitor::join('article','article.art_id','=','visitor.art_id')
					  ->select('article.art_title','visitor.visi_id','visitor.visi_ip','visitor.visi_addr','visitor.visi_deviceinfo','visitor.created_at')
					  ->orderBy('visitor.created_at','desc')
					  ->paginate(15);

        return view('admin/visitor/index',compact('visis'));
    }
}
