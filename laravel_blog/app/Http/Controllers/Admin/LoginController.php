<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\User;
use Illuminate\Http\Request;

use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use App\Http\Requests;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;

class LoginController extends CommonController
{
    public function login(){
        if($input = Input::all()){
            $_code=session('code');
            if(strtoupper($input['code'])!=$_code){
                return back()->with('msg','验证码错误');
            }
            $user=User::first();
            if($user->user_name!=$input['user_name']||Crypt::decrypt($user->user_pass)!=$input['user_pass']){
                return back()->with('msg','用户名或密码错误');
            }
            session(['user'=>$user]);
            return view('admin/index');
        }
        return view('admin/login');

    }
    public function code(){
		$phrase = new PhraseBuilder;
		// 设置验证码位数
		$code = $phrase->build(4);
		// 生成验证码图片的Builder对象，配置相应属性
		$builder = new CaptchaBuilder($code, $phrase);
		// 设置背景颜色
		$builder->setBackgroundColor(220, 210, 230);
		$builder->setMaxAngle(25);
		$builder->setMaxBehindLines(0);
		$builder->setMaxFrontLines(0);
		// 可以设置图片宽高及字体
		$builder->build($width = 100, $height = 40, $font = null);
		// 获取验证码的内容
		$phrase = $builder->getPhrase();
		// 把内容存入session
		session(['code'=>strtoupper($phrase)]);
		// 生成图片
		header("Cache-Control: no-cache, must-revalidate");
		header("Content-Type:image/jpeg");
		$builder->output();
    }
    public function quit(){
        session(['user'=>null]);
        return redirect('admin/login');
    }
}
