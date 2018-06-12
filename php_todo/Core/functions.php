<?php
/**
 * 获取环境配置
 * @auther zjx
 * @date   2017-12-05
 * @return [type]     [description]
 */
function env($name, $default='')
{
    return \Core\Library\Env::get($name, $default);
}
/**
 * 获取或设置配置参数
 * @auther zjx
 * @date   2017-12-06
 * @param string|array  $name 配置变量
 * @param mixed         $value 配置值
 * @param mixed         $default 默认值
 * @return mixed
 */
function config($name=null, $value=null, $default=null)
{
    // 无值时默认为获取配置
    if (is_null($value)) {
        return \Core\Library\Config::get($name, $default);
    } else {
        return \Core\Library\Config::set($name, $value);
    }
}
/**
 * 日志写入
 * @auther zjx
 * @date   2017-12-07
 * @param  string     $content 日志
 * @return void
 */
function write_log($content, $type='COMMON', $level='INFO')
{
    return Core\Library\Log::write($content, $type, $level);
}
/**
 * 判断提交方式
 * @auther zjx
 * @date   2017-12-07
 * @return boolean
 */
function is_ajax()
{
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH'])=='XMLHTTPREQUEST';
}
/**
 * 判断提交方式
 * @auther zjx
 * @date   2017-12-07
 * @return boolean
 */
function is_post()
{
    return isset($_SERVER['REQUEST_METHOD']) && strtoupper($_SERVER['REQUEST_METHOD'])=='POST';
}
/**
 * 判断提交方式
 * @auther zjx
 * @date   2017-12-07
 * @return boolean
 */
function is_get()
{
    return isset($_SERVER['REQUEST_METHOD']) && strtoupper($_SERVER['REQUEST_METHOD'])=='GET';
}
/**
 * 格式化打印
 * @auther zjx
 * @date   2017-12-05
 * @param  mixed     $data 打印的数据
 * @return mixed
 */
function dump($data)
{
    if (!isset($data)) {
        return '';
    }
    echo '<pre>';
    var_dump($data);
}
/**
 * 格式化打印并结束程序运行
 * @auther zjx
 * @date   2017-12-05
 * @param  mixed     $data 打印的数据
 * @return mixed
 */
function dd($data)
{
    if (!isset($data)) {
        return '';
    }
    echo '<pre>';
    var_dump($data);
    die;
}
