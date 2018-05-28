<?php

namespace app\modules\controllers;

use yii\web\Controller;
use Yii;

class CommonController extends Controller
{
    public $layout = 'layout1';
    protected $actions = ['*'];
    protected $verbs = [];
    protected $except = [];
    protected $mustlogin = [];
    public function behaviors(){
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'user' => 'admin',
                'only' => $this->actions,
                'except' =>$this->except,
                'rules' => [
                    [
                        'allow' => false,
                        'actions' => empty($this->mustlogin) ? [] : $this->mustlogin,
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => empty($this->mustlogin) ? [] : $this->mustlogin,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => $this->verbs,
            ],
        ];
    }

    public function beforeAction($action){
        if (!parent::beforeAction($action)){
            return false;
        }
        $controller = $action->controller->id;
        $actionName = $action->id;
        if (Yii::$app->admin->can($controller."/*")){
            return true;
        }

        if (Yii::$app->admin->can($controller."/".$actionName)){
            return true;
        }
        return true;
        throw new \yii\web\UnauthorizedHttpException("没有权限");
    }

    public function init()
    {

    }
}
