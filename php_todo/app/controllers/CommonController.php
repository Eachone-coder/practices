<?php
namespace app\controllers;

use Core\Library\Controller;

/**
 * 用户类
 */
class CommonController extends Controller
{
    public function init(){
        if(empty($_SESSION['user_id'])){
            header('Location: /user/login');
        }
    }
}
