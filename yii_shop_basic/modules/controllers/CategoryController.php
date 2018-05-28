<?php

namespace app\modules\controllers;

use app\models\Category;
use yii\web\Controller;
use app\modules\controllers\CommonController;
use Yii;

/**
 * 商品类别控制器
 */
class CategoryController extends CommonController
{
    /**
     * 类别列表
     * @auther zjx
     * @date   2017-12-04
     * @return [type]     [description]
     */
    public function actionList()
    {
        $this->layout = "layout1";
        $model = new Category;
        $cates = $model->getTreeList();
        return $this->render("cates", ['cates' => $cates]);
    }
    /**
     * 类别添加
     * @auther zjx
     * @date   2017-12-04
     * @return [type]     [description]
     */
    public function actionAdd()
    {
        $model = new Category();
        $list = $model->getOptions();
        $this->layout = "layout1";
        if (is_post()) {
            $post = post_info();
            if ($model->add($post)) {
                Yii::$app->session->setFlash("info", "添加成功");
            }
        }
        return $this->render("add", ['list' => $list, 'model' => $model]);
    }
    /**
     * 类别修改
     * @auther zjx
     * @date   2017-12-04
     * @return [type]     [description]
     */
    public function actionMod()
    {
        $this->layout = "layout1";
        $cateid = get_info('cateid');
        $model = Category::find()->where('cateid = :id', [':id' => $cateid])->one();
        if (is_post()) {
            $post = post_info();
            if ($model->load($post) && $model->save()) {
                Yii::$app->session->setFlash('info', '修改成功');
            }
        }
        $list = $model->getOptions();
        return $this->render('add', ['model' => $model, 'list' => $list]);
    }
    /**
     * 类别删除
     * @auther zjx
     * @date   2017-12-04
     * @return [type]     [description]
     */
    public function actionDel()
    {
        try {
            $cateid = get_info('cateid');
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
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('info', $e->getMessage());
        }
        return $this->redirect(['category/list']);
    }
}
