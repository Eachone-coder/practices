<?php
namespace Core\Library;

/**
 * 配置文件类
 */
class Config
{
    public static $_config = [];

    // TODO:
    public function __construct()
    {
    }
    /**
     * 获取配置参数
     * @auther zjx
     * @date   2017-12-06
     * @param  string     $name    配置名
     * @param  string     $default 默认值
     * @return string
     */
    public static function get($name=null, $default=null)
    {
        // 无参数时获取所有
        if (empty($name)) {
            return self::$_config;
        }
        if (isset(self::$_config[$name])) {
            return self::$_config[$name];
        } else {
            return $default;
        }
    }
    /**
     * 设置配置
     * @auther zjx
     * @date   2017-12-06
     * @param  string|array     $name  配置变量
     * @param  string           $value 配置值
     */
    public static function set($name=null, $value=null)
    {
        // 单个赋值
        if (is_string($name)) {
            self::$_config[$name] = $value;
            return;
        }
        // 批量赋值
        if (is_array($name)) {
            self::$_config = array_merge(self::$_config, $name);
            return;
        }
    }
}
