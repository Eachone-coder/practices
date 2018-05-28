<?php

namespace app\modules\controllers;

use app\models\Order;
use app\models\OrderDetail;
use app\models\Product;
use app\models\User;
use app\models\Address;
use yii\web\Controller;
use yii\data\Pagination;
use Yii;
use app\modules\controllers\CommonController;

/**
 * 订单控制器
 */
class OrderController extends CommonController
{
    /**
     * 订单列表
     * @auther zjx
     * @date   2017-12-05
     * @return [type]     [description]
     */
    public function actionList()
    {
        $model = Order::find();
        $count = $model->count();
        $pageSize = Yii::$app->params['pageSize']['order'];
        $pager = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);
        $data = $model->offset($pager->offset)->limit($pager->limit)->all();
        $data = (new Order)->getDetail($data);
        $this->layout = "layout1";
        return $this->render('list', ['pager' => $pager, 'orders' => $data]);
    }
    /**
     * 订单详情
     * @auther zjx
     * @date   2017-12-05
     * @return [type]     [description]
     */
    public function actionDetail()
    {
        $orderid = (int)get_info('orderid');
        $order = Order::find()->where('orderid = :oid', [':oid' => $orderid])->one();
        $data = Order::getData($order);
        $this->layout = "layout1";
        return $this->render('detail', ['order' => $data]);
    }
    /**
     * 发货
     * @auther zjx
     * @date   2017-12-05
     * @return [type]     [description]
     */
    public function actionSend()
    {
        $orderid = (int)get_info('orderid');
        $model = Order::find()->where('orderid = :oid', [':oid' => $orderid])->one();
        $model->scenario = "send";
        if (is_post()) {
            $post = post_info();
            $model->status = Order::SENDED;
            if ($model->load($post) && $model->save()) {
                Yii::$app->session->setFlash('info', '发货成功');
            }
        }
        $this->layout = "layout1";
        return $this->render('send', ['model' => $model]);
    }
}
