<?php

namespace app\modules\controllers;

use yii\web\Controller;
use yii\data\Pagination;
use app\models\User;
use app\models\Profile;
use Yii;
use app\modules\controllers\CommonController;

/**
 * 会员控制器
 */
class UserController extends CommonController
{
    /**
     * 会员列表
     * @auther zjx
     * @date   2017-12-04
     * @return [type]     [description]
     */
    public function actionUsers()
    {
        $model = User::find()->joinWith('profile');
        $count = $model->count();
        $pageSize = Yii::$app->params['pageSize']['user'];
        $pager = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);
        $users = $model->offset($pager->offset)->limit($pager->limit)->all();
        $this->layout = 'layout1';
        return $this->render('users', ['users' => $users, 'pager' => $pager]);
    }
    /**
     * 会员注册
     * @auther zjx
     * @date   2017-12-04
     * @return [type]     [description]
     */
    public function actionReg()
    {
        $this->layout = "layout1";
        $model = new User;
        if (is_post()) {
            $post = post_info();
            if ($model->reg($post)) {
                Yii::$app->session->setFlash('info', '添加成功');
            }
        }
        $model->userpass = '';
        $model->repass = '';
        return $this->render("reg", ['model' => $model]);
    }
    /**
     * 会员删除
     * @auther zjx
     * @date   2017-12-04
     * @return [type]     [description]
     */
    public function actionDel()
    {
        try {
            $userid = (int)get_info('userid');
            if (empty($userid)) {
                throw new \Exception();
            }
            $trans = Yii::$app->db->beginTransaction();
            if ($obj = Profile::find()->where(['userid' => $userid])->one()) {
                $res = Profile::deleteAll(['userid'=>$userid]);
                if (empty($res)) {
                    throw new \Exception;
                }
            }
            if (!User::deleteAll(['userid'=>$userid])) {
                throw new \Exception();
            }
            $trans->commit();
        } catch (\Exception $e) {
            if (Yii::$app->db->getTransaction()) {
                $trans->rollback();
            }
        }
        $this->redirect(['user/users']);
    }
}
