<?php
namespace app\modules\models;

use yii\db\ActiveRecord;
use Yii;

class Admin extends ActiveRecord
{
    public $rememberMe = true;
    public $repass;
    public static function tableName()
    {
        return "{{%admin}}";
    }

    public function attributeLables()
    {
        return [
            'amdinuser' => '管理员帐号',
            'amdinemail' => '管理员邮箱',
            'amdinpass' => '管理员密码',
            'repass' => '确认密码',
        ];
    }
    /**
     * 验证规则
     *
     * @Author   zjx
     * @DateTime 2017-11-30T13:19:32+0800
     * @return   [type]                   [description]
     */
    public function rules()
    {
        return [
            ['adminuser', 'required', 'message' => '管理员账号不能为空', 'on' => ['login', 'seekpass', 'changepass', 'adminadd', 'changeemail']],
            ['adminpass', 'required', 'message' => '管理员密码不能为空', 'on' => ['login', 'changepass', 'adminadd', 'changeemail']],
            ['rememberMe', 'boolean', 'on' => 'login'],
            ['adminpass', 'validatePass', 'on' => ['login', 'changeemail']],
            ['adminemail', 'required', 'message' => '电子邮箱不能为空', 'on' => ['seekpass', 'adminadd', 'changeemail']],
            ['adminemail', 'email', 'message' => '电子邮箱格式不正确', 'on' => ['seekpass', 'adminadd', 'changeemail']],
            ['adminemail', 'unique', 'message' => '电子邮箱已被注册', 'on' => ['adminadd', 'changeemail']],
            ['adminuser', 'unique', 'message' => '管理员已被注册', 'on' => 'adminadd'],
            ['adminemail', 'validateEmail', 'on' => 'seekpass'],
            ['repass', 'required', 'message' => '确认密码不能为空', 'on' => ['changepass', 'adminadd']],
            ['repass', 'compare', 'compareAttribute' => 'adminpass', 'message' => '两次密码输入不一致', 'on' => ['changepass', 'adminadd']],
        ];
    }
    /**
     * 验证密码
     *
     * @Author   zjx
     * @DateTime 2017-11-30T13:24:03+0800
     * @return   [type]                   [description]
     */
    public function validatePass()
    {
        if (!$this->hasErrors()) {
            $where['adminuser'] = $this->adminuser;
            $where['adminpass'] = md5($this->adminpass);
            $data = self::find()->where($where)->one();
            if (is_null($data)) {
                $this->addError('adminpass', '用户名或密码错误');
            }
        }
    }
    /**
     * 验证邮箱
     *
     * @Author   zjx
     * @DateTime 2017-11-30T13:26:06+0800
     * @return   [type]                   [description]
     */
    public function validateEmail()
    {
        if (!$this->hasErrors()) {
            $where['adminuser'] = $this->adminuser;
            $where['adminemail'] = $this->adminemail;
            $data = self::find()->where($where)->one();
            if (is_null($data)) {
                $this->addError('adminmail', '管理员电子邮箱错误');
            }
        }
    }
    /**
     * 登录操作
     *
     * @Author   zjx
     * @DateTime 2017-11-30T13:19:46+0800
     * @param    [type]                   $data [description]
     * @return   [type]                         [description]
     */
    public function login($data)
    {
        // 场景，用于区分验证
        $this->scenario = 'login';
        // 验证
        if ($this->load($data) && $this->validate()) {
            $lifeTime = $this->rememberMe ? 24*60*60 : 0;
            $session = Yii::$app->session;
            session_set_cookie_params($lifeTime);
            $session['admin'] = [
                'adminuser' => $this->adminuser,
                'isLogin' => 1,
            ];
            $this->updateAll(['logintime' => time(), 'loginip' => ip2long(Yii::$app->request->userIP)], 'adminuser = :user', [':user' => $this->adminuser]);
            return (bool)$session['admin']['isLogin'];
        }
        return false;
    }
    /**
     * 找回密码
     * @auther zjx
     * @date   2017-11-30
     * @param  [type]     $data [description]
     * @return [type]           [description]
     */
    public function seekPass($data)
    {
        $this->scenario = 'seekpass';
        if ($this->load($data) && $this->validate()) {
            $time = time();
            $token = $this->createToken($data['Admin']['adminuser'], $time);
            $mailer = Yii::$app->mailer->compose('seekpass', ['adminuser' => $data['Admin']['adminuser'], 'time' => $time, 'token' => $token]);
            $mailer->setFrom('977904037@qq.com');
            $mailer->setTo($data['Admin']['adminemail']);
            $mailer->setSubject('慕课商城-找回密码');
            if ($mailer->send()) {
                return true;
            }
        }
        return false;
    }
    /**
     * 创建token
     * @auther zjx
     * @date   2017-11-30
     * @param  [type]     $adminuser [description]
     * @param  [type]     $time      [description]
     * @return [type]                [description]
     */
    public function createToken($adminuser, $time)
    {
        return md5(md5($adminuser).base64_encode(Yii::$app->request->userIP).md5($time));
    }
    /**
     * 修改密码
     * @auther zjx
     * @date   2017-12-04
     * @param  [type]     $data [description]
     * @return [type]           [description]
     */
    public function changePass($data)
    {
        $this->scenario = 'changepass';
        if ($this->load($data) && $this->validate()) {
            return (bool)$this->updateAll(['adminpass' => md5($this->adminpass)], 'adminuser = :user', [':user' => $this->adminuser]);
        }
        return false;
    }
    /**
     * 注册
     * @auther zjx
     * @date   2017-11-30
     * @param  [type]     $data [description]
     * @return [type]           [description]
     */
    public function reg($data)
    {
        $this->scenario = 'adminadd';
        if ($this->load($data) && $this->validate()) {
            $this->adminpass = md5($this->adminpass);
            $this->createtime = time();
            if ($this->save(false)) {
                return true;
            }
            return false;
        }
        return false;
    }
    /**
     * 修改邮箱
     * @auther zjx
     * @date   2017-11-30
     * @param  [type]     $data [description]
     * @return [type]           [description]
     */
    public function changeEmail($data)
    {
        $this->scenario = 'changeemail';
        if ($this->load($data) && $this->validate()) {
            return (bool)$this->updateAll(['adminemail' => $this->adminemail], 'adminuser = :user', [':user' => $this->adminuser]);
        }
    }
}
