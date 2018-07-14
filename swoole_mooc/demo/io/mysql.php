<?php
/**
 * User: zjx
 * Date: 2018/6/20
 * Time: 22:05
 */

class AsyMysql
{

    public $dbSource = '';
    public $dbConfig = '';

    public function __construct()
    {
        // new swoole_mysql
        $this->dbSource = new Swoole\Mysql;

        $this->dbConfig = [
            'host' => '127.0.0.1',
            'port' => 3306,
            'user' => 'homestead',
            'password' => 'secret',
            'database' => 'homestead',
            'charset' => 'utf8'
        ];
    }

    public function update()
    {

    }

    public function add()
    {

    }

    public function execute($id, $username)
    {
        // 连接数据库
        $this->dbSource->connect($this->dbConfig, function ($db, $result) use ($id, $username) {
            echo "mysql-connect" . PHP_EOL;
            if ($result == false) {
                var_dump($db->connect_error);
            }
            // $sql = "select * from test where id = {$id} and username = '{$username}'";
            $sql = "update test set `username` = '{$username}' where id = {$id}";
            // query (add select update delete)
            $db->query($sql, function ($db, $result) {
                /**
                 * select => result 返回查询结果内容
                 * add update delete => result 返回布尔值
                 */
                if ($result === false) {

                } elseif ($result === true) {
                    var_dump($db->affected_rows);
                } else {
                    var_dump($result);
                }
                $db->close();
            });
        });
        return true;
    }
}

$asyMysql = new AsyMysql();

$flag = $asyMysql->execute(1, 'zjx');

var_dump($flag) . PHP_EOL;

echo "start" . PHP_EOL;
