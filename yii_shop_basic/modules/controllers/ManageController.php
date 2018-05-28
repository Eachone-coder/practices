<?php

namespace app\modules\controllers;

use yii\web\Controller;
use Yii;
use app\modules\models\Admin;
use yii\data\Pagination;
use app\modules\controllers\CommonController;

/**
 * 管理员控制器
 */
class ManageController extends CommonController
{
    /**
     * 邮箱修改密码
     * @auther zjx
     * @date   2017-11-30
     * @return [type]     [description]
     */
    public function actionMailchangepass()
    {
        $this->layout = false;
        $time = get_info("timestamp");
        $adminuser = get_info("adminuser");
        $token = get_info("token");
        $model = new Admin;
        $myToken = $model->createToken($adminuser, $time);
        if ($token != $myToken) {
            $this->redirect(['public/login']);
            Yii::$app->end();
        }
        if (time() - $time > 300) {
            $this->redirect(['public/login']);
            Yii::$app->end();
        }
        if (is_post()) {
            $post = post_info();
            if ($model->changePass($post)) {
                Yii::$app->session->setFlash('info', '密码修改成功');
            }
        }
        $model->adminuser = $adminuser;
        return $this->render("mailchangepass", ['model' => $model]);
    }
    /**
     * 管理员列表
     * @auther zjx
     * @date   2017-12-04
     * @return [type]     [description]
     */
    public function actionManagers()
    {
        $this->layout = "layout1";
        $model = Admin::find();
        $count = $model->count();
        $pageSize = Yii::$app->params['pageSize']['manage'];
        $pager = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);
        $managers = $model->offset($pager->offset)->limit($pager->limit)->all();
        return $this->render("managers", ['managers' => $managers, 'pager' => $pager]);
    }
    /**
     * 管理员注册
     * @auther zjx
     * @date   2017-12-04
     * @return [type]     [description]
     */
    public function actionReg()
    {
        $this->layout = 'layout1';
        $model = new Admin;
        if (is_post()) {
            $post = post_info();
            if ($model->reg($post)) {
                Yii::$app->session->setFlash('info', '添加成功');
            } else {
                Yii::$app->session->setFlash('info', '添加失败');
            }
        }
        $model->adminpass = '';
        $model->repass = '';
        return $this->render('reg', ['model' => $model]);
    }
    /**
     * 管理员删除
     * @auther zjx
     * @date   2017-12-04
     * @return [type]     [description]
     */
    public function actionDel()
    {
        $adminid = (int)Yii::$app->request->get("adminid");
        if (empty($adminid) || $adminid == 1) {
            $this->redirect(['manage/managers']);
            return false;
        }
        $model = new Admin;
        if ($model->deleteAll('adminid = :id', [':id' => $adminid])) {
            Yii::$app->session->setFlash('info', '删除成功');
            $this->redirect(['manage/managers']);
        }
    }
    /**
    * 管理员修改邮箱
     * @auther zjx
     * @date   2017-12-04
     * @return [type]     [description]
     */
    public function actionChangeemail()
    {
        $this->layout = 'layout1';
        $model = Admin::find()->where('adminuser = :user', [':user' => Yii::$app->session['admin']['adminuser']])->one();
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($model->changeemail($post)) {
                Yii::$app->session->setFlash('info', '修改成功');
            }
        }
        $model->adminpass = "";
        return $this->render('changeemail', ['model' => $model]);
    }
    /**
     * 管理员修改密码
     * @auther zjx
     * @date   2017-12-04
     * @return [type]     [description]
     */
    public function actionChangepass()
    {
        $this->layout = "layout1";
        $model = Admin::find()->where('adminuser = :user', [':user' => Yii::$app->session['admin']['adminuser']])->one();
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($model->changepass($post)) {
                Yii::$app->session->setFlash('info', '修改成功');
            }
        }
        $model->adminpass = '';
        $model->repass = '';
        return $this->render('changepass', ['model' => $model]);
    }
}
