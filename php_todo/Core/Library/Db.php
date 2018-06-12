<?php
namespace Core\Library;

/**
 * 数据库操作类
 */
class Db
{
    /**
     * 私有化数据库对象
     * @var object
     */
    private static $instance;
    private $link;
    private $conn;/**暂时不用**/
    private $host;
    private $port;
    private $user;
    private $pass;
    private $query;
    private $dbname;
    private $prefix;/**暂时不用**/
    private $charset;/**暂时不用**/


    /**
     * 私有化
     * @auther zjx
     * @date   2017-12-05
     */
    private function __construct()
    {
        $this->conn = config('DB_CONNECTION');
        $this->host = config('DB_HOST');
        $this->port = config('DB_PORT');
        $this->user = config('DB_USERNAME');
        $this->pass = config('DB_PASSWORD');
        $this->dbname = config('DB_DATABASE');
        $this->connect();
    }
    /**
     * 获取数据库对象
     * @auther zjx
     * @date   2017-12-05
     * @return object
     */
    public static function getInstance()
    {
        if (self::$instance) {
            return self::$instance;
        }
        self::$instance = new Db();
        return self::$instance;
    }
    /**
     * 连接数据库
     * @auther zjx
     * @date   2017-12-06
     */
    private function connect()
    {
        $dsn = 'mysql:dbname='.$this->dbname.';host='.$this->host.';port='.$this->port.'';
        try {
            $option = [\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8;"];
            $this->link = new \PDO($dsn, $this->user, $this->pass, $option);
            $this->link->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->link->setAttribute(\PDO::ATTR_EMULATE_PREPARES, true);
        } catch (\PDOException $e) {
            write_log($e->getMessage(), 'SQL', 'ERROR');
            throw new \Exception('数据库连接失败');
        }
    }
    /**
     * 查询
     * @auther zjx
     * @date   2017-12-06
     * @param  string     $sql   查询语句
     * @param  array     $param 参数
     * @return mixed
     */
    public function query($sql, $param=null)
    {
        $this->query = $this->link->prepare($sql);
        if (!is_null($param)) {
            $this->query->execute($param);
        } else {
            $this->query->execute();
        }
        write_log($sql, 'SQL');
        return $this->query->fetchAll();
    }
    /**
     * 插入
     * @auther zjx
     * @date   2017-12-06
     * @param  string     $sql   语句
     * @param  array     $param 参数
     * @return integer
     */
    public function insert($sql, $param=null)
    {
        $this->query = $this->link->prepare($sql);
        if (!is_null($param)) {
            $this->query->execute($param);
        } else {
            $this->query->execute();
        }
        write_log($sql, 'SQL');
        return $this->link->lastInsertId();
    }
    /**
     * 执行
     * @auther zjx
     * @date   2017-12-06
     * @param  string     $sql   语句
     * @param  array     $param 参数
     * @return boolean
     */
    public function exec($sql, $param=null)
    {
        $this->query = $this->link->prepare($sql);
        write_log($sql, 'SQL');
        if (!is_null($param)) {
            return $this->query->execute($param);
        } else {
            return $this->query->execute();
        }
    }
}
