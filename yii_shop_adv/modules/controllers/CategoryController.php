<?php

namespace app\modules\controllers;
use app\models\Category;
use yii\web\Controller;
use app\modules\controllers\CommonController;
use Yii;

class CategoryController extends CommonController
{
    public function actionList()
    {
        $this->layout = "layout1";
        $model = new Category;
        // $cates = $model->getTreeList();
        $page = (int)Yii::$app->request->get('page') ? (int)Yii::$app->request->get('page') : 1;
        $perpage = (int)Yii::$app->request->get('per-page') ? (int)Yii::$app->request->get('per-page') : 10;
        $data = $model->getPrimaryCate();
        return $this->render("cates", ['pager' => $data['pages'],'page'=>$page,'perpage'=>$perpage]);
    }

    public function actionAdd()
    {
        $model = new Category();
        $list = $model->getOptions();
        $this->layout = "layout1";
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($model->add($post)) {
                Yii::$app->session->setFlash("info", "添加成功");
            }
        }
        return $this->render("add", ['list' => $list, 'model' => $model]);
    }

    public function actionMod()
    {
        $this->layout = "layout1";
        $cateid = Yii::$app->request->get("cateid");
        $model = Category::find()->where('cateid = :id', [':id' => $cateid])->one();
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($model->load($post) && $model->save()) {
                Yii::$app->session->setFlash('info', '修改成功');
            }
        }
        $list = $model->getOptions();
        return $this->render('add', ['model' => $model, 'list' => $list]);
    }

    public function actionDel()
    {
        try {
            $cateid = Yii::$app->request->get('cateid');
            if (empty($cateid)) {
                throw new \Exception('参数错误');
            }
            $data = Category::find()->where('parentid = :pid', [":pid" => $cateid])->one();
            if ($data) {
                throw new \Exception('该分类下有子类，不允许删除');
            }
            if (!Category::deleteAll('cateid = :id', [":id" => $cateid])) {
                throw new \Exception('删除失败');
            }
        } catch(\Exception $e) {
            Yii::$app->session->setFlash('info', $e->getMessage());
        }
        return $this->redirect(['category/list']);
    }

    public function actionTree(){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = new Category;
        $data = $model->getPrimaryCate();
        if(!empty($data)){
            return $data['data'];
        }
        return [];
    }

    public function actionRename(){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(!Yii::$app->request->isAjax){
            throw new \yii\web\MethodNotAllowedHttpException();
        }
        $newtext = Yii::$app->request->post('newtext');
        $oldtext = Yii::$app->request->post('oldtext');
        $id = Yii::$app->request->post('id');
        if(empty($newtext) || empty($id)){
            return ['code'=>-1,'msg'=>'参数错误','data'=>[]];
        }

        $cate = Category::findOne($id);
        if(empty($cate)){
            return ['code'=>-1,'msg'=>'参数错误','data'=>[]];
        }
        $cate->title = $newtext;
        $cate->scenario = 'rename';
        if ($cate->save()){
            return ['code'=>0,'msg'=>'修改成功','data'=>[]];
        }
        return ['code'=>1,'msg'=>'修改失败','data'=>[]];
    }

    public function actionDelete(){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(!Yii::$app->request->isAjax){
            throw new \yii\web\MethodNotAllowedHttpException();
        }
        $id = Yii::$app->request->get('id');
        echo $id;
        $cate = Category::findOne($id);
        if(empty($cate)){
            return ['code'=>-1,'msg'=>'参数错误','data'=>[]];
        }
        $total = Category::find()->where('parentid = :pid',[':pid'=>$id])->count();
        if($total > 0){
            return ['code'=>-1,'msg'=>'含有子类，不得删除','data'=>[]];
        }
        if($cate->delete()){
            return ['code'=>0,'msg'=>'删除成功','data'=>[]];
        }
        return ['code'=>1,'msg'=>'删除失败','data'=>[]];
    }
}
