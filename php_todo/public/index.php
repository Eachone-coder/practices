<?php
// 版本要求
if (version_compare(PHP_VERSION, '5.3.0', '<')) {
    die('require PHP > 5.3.0 !');
}
session_start();
// 应用目录
define('APP_PATH', '../app/');
// 运行时目录
define('RUNTIME_PATH', '../runtime/');
// 定义系统常量
defined('CORE_PATH') or define('CORE_PATH', '../Core/');
defined('LIB_PATH') or define('LIB_PATH', CORE_PATH.'Library/');
defined('LOG_PATH') or define('LOG_PATH', RUNTIME_PATH.'logs/');
defined('CONFIG_PATH') or define('CONFIG_PATH', '../config');
defined('VIEW_PATH') or define('VIEW_PATH', APP_PATH.'views/');
defined('EXT') or define('EXT', '.php');
define('IS_CGI', substr(PHP_SAPI, 0, 3)=='cgi' ? 1 : 0);
define('IS_WIN', strstr(PHP_OS, 'WIN') ? 1 : 0);
define('IS_CLI', PHP_SAPI=='cli'? 1   :   0);
define('DS', DIRECTORY_SEPARATOR);
// 引入路由
//require LIB_PATH.'Route.php';
// 引入辅助函数
require CORE_PATH.'functions.php';
// 引入核心文件
require '../Core/Core.php';
Core\Core::start();
