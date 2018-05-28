<?php

namespace app\controllers;

use app\controllers\CommonController;
use app\models\Pay;
use Yii;

/**
 * 支付控制器
 */
class PayController extends CommonController
{
    public $enableCsrfValidation = false;
    public function actionNotify()
    {
        if (is_post()) {
            $post = post_info();
            if (Pay::notify($post)) {
                echo "success";
                exit;
            }
            echo "fail";
            exit;
        }
    }

    public function actionReturn()
    {
        $this->layout = 'layout1';
        $status = get_info('trade_status');
        if ($status == 'TRADE_SUCCESS') {
            $s = 'ok';
        } else {
            $s = 'no';
        }
        return $this->render("status", ['status' => $s]);
    }
}
