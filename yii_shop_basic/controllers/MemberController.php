<?php

namespace app\controllers;

use app\models\User;
use app\controllers\CommonController;
use Yii;

class MemberController extends CommonController
{
    /**
     * 会员登录
     * @auther zjx
     * @date   2017-12-04
     * @return [type]     [description]
     */
    public function actionAuth()
    {
        $this->layout = 'layout2';
        if (is_get()) {
            $url = Yii::$app->request->referrer;
            if (empty($url)) {
                $url = "/";
            }
            Yii::$app->session->setFlash('referrer', $url);
        }
        $model = new User;
        if (is_post()) {
            $post = post_info();
            if ($model->login($post)) {
                $url = Yii::$app->session->getFlash('referrer');
                return $this->redirect($url);
            }
        }
        return $this->render("auth", ['model' => $model]);
    }
    /**
     * 退出
     * @auther zjx
     * @date   2017-12-04
     * @return [type]     [description]
     */
    public function actionLogout()
    {
        Yii::$app->session->remove('loginname');
        Yii::$app->session->remove('isLogin');
        if (!isset(Yii::$app->session['isLogin'])) {
            return $this->goBack(Yii::$app->request->referrer);
        }
    }
    /**
     * 注册
     * @auther zjx
     * @date   2017-12-04
     * @return [type]     [description]
     */
    public function actionReg()
    {
        $model = new User;
        if (is_post()) {
            $post = post_info();
            if ($model->regByMail($post)) {
                Yii::$app->session->setFlash('info', '电子邮件发送成功');
            }
        }
        $this->layout = 'layout2';
        return $this->render('auth', ['model' => $model]);
    }
    /**
     * QQ登录
     * @auther zjx
     * @date   2017-12-04
     * @return [type]     [description]
     */
    public function actionQqlogin()
    {
        require_once("../vendor/qqlogin/qqConnectAPI.php");
        $qc = new \QC();
        $qc->qq_login();
    }
    /**
     * QQ登录回调
     * @auther zjx
     * @date   2017-12-04
     * @return [type]     [description]
     */
    public function actionQqcallback()
    {
        require_once("../vendor/qqlogin/qqConnectAPI.php");
        $auth = new \OAuth();
        $accessToken = $auth->qq_callback();
        $openid = $auth->get_openid();
        $qc = new \QC($accessToken, $openid);
        $userinfo = $qc->get_user_info();
        $session = Yii::$app->session;
        $session['userinfo'] = $userinfo;
        $session['openid'] = $openid;
        if ($model = User::find()->where('openid = :openid', [':openid' => $openid])->one()) {
            $session['loginname'] = $model->username;
            $session['isLogin'] = 1;
            return $this->redirect(['index/index']);
        }
        return $this->redirect(['member/qqreg']);
    }
    /**
     * 完善信息
     * @auther zjx
     * @date   2017-12-04
     * @return [type]     [description]
     */
    public function actionQqreg()
    {
        $this->layout = "layout2";
        $model = new User;
        if (is_post()) {
            $post = post_info();
            $session = Yii::$app->session;
            $post['User']['openid'] = $session['openid'];
            if ($model->reg($post, 'qqreg')) {
                $session['loginname'] = $post['User']['username'];
                $session['isLogin'] = 1;
                return $this->redirect(['index/index']);
            }
        }
        return $this->render('qqreg', ['model' => $model]);
    }
}
