<?php
namespace app\models;

use Core\Library\Db;

/**
 * TodoList模型
 */
class TodoList
{
    /**
     * 获取所有待办事项
     * @auther zjx
     * @date   2017-12-06
     * @return array
     */
    public function getAll()
    {
        $sql = 'select * from todo_list order by status desc';
        $db = Db::getInstance();
        return $db->query($sql);
    }

    public function getActive()
    {
        $param[':status'] = 1;
        $sql = 'select * from todo_list where status = :status order by status desc';
        $db = Db::getInstance();
        return $db->query($sql,$param);
    }

    public function getCompleted()
    {
        $param[':status'] = 2;
        $sql = 'select * from todo_list where status = :status order by status desc';
        $db = Db::getInstance();
        return $db->query($sql,$param);
    }

    public function ajaxTodo($status)
    {
        switch ($status) {
            case 'all':
                return $this->getAll();
                break;
            case 'active':
                return $this->getActive();
                break;
            case 'completed':
                return $this->getCompleted();
                break;
        }
    }

    /**
     * 添加待办事项
     * @auther zjx
     * @date   2017-12-06
     * @param  string     $content 待办事项
     */
    public function addTodo($content)
    {
        $param[':content'] = $content;
        $param[':created_at'] = time();
        $sql = 'insert into todo_list (content, created_at) values (:content, :created_at)';
        $db = Db::getInstance();
        return $db->insert($sql, $param);
    }
    /**
     * 删除待办事项
     * @auther zjx
     * @date   2017-12-06
     * @param  integer     $id
     * @return boolean
     */
    public function delTodo($id)
    {
        $param[':id'] = $id;
        $sql = 'delete from todo_list where id = :id';
        $db = Db::getInstance();
        return $db->exec($sql, $param);
    }
    /**
     * 修改待办事项状态
     * @auther zjx
     * @date   2017-12-06
     * @param  integer     $id
     * @param  integer    $status 状态
     * @return boolean
     */
    public function changeTodoStatus($id, $status)
    {
        if ($status == 1) {
            $status = 2;
        } else {
            $status = 1;
        }
        $param[':id'] = $id;
        $param[':status'] = $status;
        $sql = 'update todo_list set status = :status where id = :id ';
        $db = Db::getInstance();
        return $db->exec($sql, $param);
    }
}
