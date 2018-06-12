<?php
namespace app\controllers;

use app\models\User;
use Core\Library\Controller;

/**
 * 用户类
 */
class UserController extends Controller
{
    public function login()
    {
        if (is_post()) {
            $email = $_POST['email'];
            $pass = $_POST['pass'];
            if(empty($email) || empty($pass)){
                $this->error('邮箱或密码不能为空');
            }
            $res = (new User)->login($email, $pass);
            if ($res) {
                setcookie('user_id', $res['id'], time()+60*60*24*30);
                setcookie('user_email', $res['user_email'], time()+60*60*24*30);
                $_SESSION['user_id'] = $res['id'];
                $_SESSION['user_email'] = $res['user_email'];
                header("Location: /");
            } else {
                $this->error('登录失败');
            }
        }
        $this->display();
    }
}
