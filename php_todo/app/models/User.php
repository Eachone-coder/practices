<?php
namespace app\models;

use Core\Library\Db;

/**
 * 用户模型
 */
class User
{

    public function login($email, $pass)
    {
        $pass = strtoupper(md5($pass));
        $sql = 'select * from todo_user where user_email = :email and user_pass = :pass';
        $param[':email'] = $email;
        $param[':pass'] = $pass;
        $db = Db::getInstance();
        $user = $db->query($sql, $param);
        if(empty($user)){
            return false;
        }else{
            return $user[0];
        }
    }
}
