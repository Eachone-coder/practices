<?php
namespace app\controllers;

use app\models\TodoList;
use app\controllers\CommonController;

class IndexController extends CommonController
{
    /**
     * 首页
     * @auther zjx
     * @date   2017-12-06
     * @return void
     */
    public function index()
    {
        $list = (new TodoList)->getAll();
        $this->assign('list', $list);
        $this->display();
    }

    public function ajaxTodo()
    {
        if (is_post()) {
            $status = $_POST['status'] ? $_POST['status'] : 'all';
            $list = (new TodoList)->ajaxTodo($status);
            $this->success($list);
        }
    }

    /**
     * 插入
     * @auther zjx
     * @date   2017-12-06
     */
    public function addTodo()
    {
        if (is_post()) {
            $content = $_POST['content'];
            if (empty($content)) {
                $this->error('内容不能为空');
            }
            $res = (new TodoList)->addTodo($content);
            if ($res) {
                $info = ['id'=>$res, 'content'=>$content, 'status'=>'1'];
                $this->success($info);
            } else {
                $this->error('写入错误');
            }
        }
    }
    /**
     * 删除
     * @auther zjx
     * @date   2017-12-06
     */
    public function delTodo()
    {
        if (is_post()) {
            $id = $_POST['id'];
            if (empty($id)) {
                $this->error('ID不能为空');
            }
            $res = (new TodoList)->delTodo($id);
            if ($res) {
                $this->success('删除成功');
            } else {
                $this->error('删除失败');
            }
        }
    }
    /**
     * 更改状态
     * @auther zjx
     * @date   2017-12-06
     */
    public function changeTodoStatus()
    {
        if (is_post()) {
            $id = $_POST['id'];
            $status = $_POST['status'];
            if (empty($id)) {
                $this->error('ID不能为空');
            }
            $res = (new TodoList)->changeTodoStatus($id, $status);
            if ($res) {
                $this->success('更改成功');
            } else {
                $this->error('更改失败');
            }
        }
    }
}
