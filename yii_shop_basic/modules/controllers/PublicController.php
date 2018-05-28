<?php

namespace app\modules\controllers;

use yii\web\Controller;
use app\modules\models\Admin;
use Yii;

/**
 * Default controller for the `admin` module
 */
class PublicController extends Controller
{
    /**
     * 登录页
     *
     * @Author   zjx
     * @DateTime 2017-11-30
     * @return   [type]                   [description]
     */
    public function actionLogin()
    {
        $model = new Admin;

        if (is_post()) {
            $post = post_info();
            if ($model->login($post)) {
                $this->redirect(['default/index']);
                Yii::$app->end();
            }
        }

        $this->layout = false;
        return $this->render('login', ['model'=>$model]);
    }
    /**
     * 退出
     * @auther zjx
     * @date   2017-11-30
     * @return [type]     [description]
     */
    public function activeLogout()
    {
        Yii::$app->session->removeAll();
        if (!isset(Yii::$app->session['admin']['isLogin'])) {
            $this->redirect(['public/login']);
            Yii::$app->end();
        }
        $this->goback();
    }
    /**
     * 找回密码
     * @auther zjx
     * @date   2017-11-30
     * @return [type]     [description]
     */
    public function actionSeekpassword()
    {
        $model = new Admin;
        if (is_post()) {
            $post = post_info();
            if ($model->seekPass($post)) {
                Yii::$app->session->setFlash('info', '电子邮件已经发送成功，请查收');
            }
        }
        $this->layout = false;
        return $this->render('seekpassword', ['model' => $model]);
    }
}
