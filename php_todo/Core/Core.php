<?php
namespace core;

use Core\Library\Route;
use Core\Library\Env;
use Core\Library\Config;

/**
 * 核心类
 */
class Core
{
    // 类映射
    private static $_map = [];
    // 实例化对象
    private static $_instance = [];
    /**
     * 初始化
     * @auther zjx
     * @date   2017-12-05
     * @return void
     */
    public static function start()
    {
        ini_set('date.timezone','Asia/Shanghai');
        // 注册自动加载
        spl_autoload_register('core\Core::autoload');
        // 注册错误和异常处理
        register_shutdown_function('core\Core::fatalError');
        set_error_handler('core\Core::appError');
        set_exception_handler('core\Core::appException');
        // 环境变量
        $envFile = '../.env';
        if (is_file($envFile)) {
            $handle = fopen($envFile, 'r');
            while ($value = fgets($handle)) {
                $value = trim($value);
                if (empty($value)) {
                    continue;
                }
                Env::set($value);
            }
        }
        // 处理配置文件
        $configFile = CONFIG_PATH.DS.'config.php';
        Config::set(include $configFile);
        // 处理路由
        $route = new Route;
        $action = $route->action;
        define('ACTION_NAME', $action);
        $ctrlClass = ucfirst($route->ctrl);
        define('CONTROLLER_NAME', $ctrlClass);
        $ctrlFile = APP_PATH.'controllers'.DS.$ctrlClass.'Controller.php';
        // TODO: 这里出现bug，已改正
        // $ctrlClass = 'app'.DS.'controllers'.DS.$ctrlClass.'Controller';
        $ctrlClass = '\\app'.'\controllers\\'.$ctrlClass.'Controller';
        if (is_file($ctrlFile)) {
            include $ctrlFile;
            $ctrl = new $ctrlClass();
            $ctrl->$action();
        } else {
            throw new \Exception('找不到控制器'.$ctrlClass);
        }
    }
    /**
     * 自动加载
     * @auther zjx
     * @date   2017-12-05
     * @param  string     $class 类名
     * @return void
     */
    public static function autoload($class)
    {
        // 检查是否存在映射
        if (isset(self::$_map[$class])) {
            include self::$_map[$class];
        }
        $name = strstr($class, '\\', true);
        // TODO: 目前不用判断了
        // 判断是加载框架类还是应用类
        // if (in_array($name, ['core'])) {
        //     $path = '../';
        // } else {
        //     $path = APP_PATH;
        // }
        $path = '../';
        $filename = $path . str_replace('\\', '/', $class) . EXT;
        if (is_file($filename)) {
            // Win环境下面严格区分大小写
            if (IS_WIN && false === strpos(str_replace('/', '\\', realpath($filename)), $class . EXT)) {
                return ;
            }
            include $filename;
        }
    }
    /**
     * 自定义异常处理
     * @auther zjx
     * @date   2017-12-07
     * @param  mixed     $e 异常对象
     */
    public static function appException($e)
    {
        write_log($e->getMessage().' '.$e->getFile().'第'.$e->getLine().'行', $e->getCode(), 'EXCEPTION');
        header('HTTP/1.1 404 Not Found');
        header('Status:404 Not Found');
    }
    /**
     * 自定义错误处理
     * @auther zjx
     * @date   2017-12-07
     * @param  int     $errno   错误类型
     * @param  string     $errstr  错误信息
     * @param  string     $errfile 错误文件
     * @param  int     $errline 错误行数
     * @return void
     */
    public static function appError($errno, $errstr, $errfile, $errline)
    {
        switch ($errno) {
            case E_ERROR:
            case E_PARSE:
            case E_CORE_ERROR:
            case E_COMPILE_ERROR:
            case E_USER_ERROR:
                ob_end_clean();
                $errorStr = "$errstr ".$errfile." 第 $errline 行.";
                write_log($errorStr, 'COMMON', $errno);
                break;
            case E_STRICT:
            case E_USER_WARNING:
            case E_USER_NOTICE:
            default:
                $errorStr = "$errstr ".$errfile." 第 $errline 行.";
                write_log($errorStr, 'COMMON', $errno);
                break;
        }
    }
    /**
     * 致命错误捕获
     * @auther zjx
     * @date   2017-12-07
     * @return [type]     [description]
     */
    public static function fatalError()
    {
        if ($e = error_get_last()) {
            switch($e['type']){
              case E_ERROR:
              case E_PARSE:
              case E_CORE_ERROR:
              case E_COMPILE_ERROR:
              case E_USER_ERROR:
                ob_end_clean();
                write_log($e->getMessage(), 'COMMON', $e->getCode());
                break;
            }
        }
    }
}
