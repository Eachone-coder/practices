<?php
/**
接收用户消息的控制器
**/
namespace App\Http\Controllers\Wechat;

use App\Http\Controllers\Controller;
use EasyWeChat\Foundation\Application;

class ReplyController extends Controller{
    public function serve(){
		//Log::info('request arrived.'); # 注意：Log 为 Laravel 组件，所以它记的日志去 Laravel 日志看，而不是 EasyWeChat 日志

        $wechat = app('wechat');
        $wechat->server->setMessageHandler(function($message){
            if ($message->MsgType == 'event') {
				return $message->Event;
				switch ($message->Event) {
					case 'subscribe':
						return '欢迎关注';
						break;
					case 'scan':
						return '欢迎扫码';
						break;
					default:
						return $message->Event;
						break;
				}
			}
			
			return '你想干啥!!!';
        });
        //Log::info('return response.');

        return $wechat->server->serve();
    }
}
