<?php
/**
接收用户消息的控制器
**/
namespace App\Http\Controllers\Wechat;

use App\Http\Controllers\Controller;
use EasyWeChat\Foundation\Application;

class MenuController extends Controller{
    public function set(){
		$options=config('wechat');
		$app = new Application($options);
		$menu = $app->menu;
		$buttons = [
			[
				"type" => "click",
				"name" => "今日歌曲",
				"key"  => "V1001_TODAY_MUSIC"
			],
			[
				"name"       => "菜单",
				"sub_button" => [
					[
						"type" => "view",
						"name" => "搜索",
						"url"  => "http://www.soso.com/"
					],
					[
						"type" => "view",
						"name" => "视频",
						"url"  => "http://v.qq.com/"
					],
					[
						"type" => "click",
						"name" => "赞一下我们",
						"key" => "V1001_GOOD"
					],
				],
			],
		];
		$menu->add($buttons);
    }
}
