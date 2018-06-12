<?php
namespace Core\Library;

/**
 * 环境变量类
 */
class Env
{
    /**
     * 获取环境变量
     * @auther zjx
     * @date   2017-12-05
     * @param  string     $name    环境变量名
     * @param  string     $default 默认值
     * @return mixed
     */
    public static function get($name, $default = '')
    {
        $value = getenv($name);
        if (false !== $value) {
            if ('false' === $value) {
                $value = false;
            } elseif ('true' === $value) {
                $value = true;
            }
            return $value;
        }
        return $default;
    }
    /**
     * 设置环境变量
     * @auther zjx
     * @date   2017-12-06
     * @param  string     $value name=value格式
     */
    public static function set($value)
    {
        try {
            putenv($value);
        } catch (Exception $e) {
            throw new \Exception('设置环境变量失败'.$value);
        }
    }
}
