<?php
namespace Core\Library;

/**
 * 路由类
 */
class Route
{
    public function __construct()
    {
        if (isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] != '/') {
            $path = $_SERVER['REQUEST_URI'];
            $pathArr = explode('/', trim($path, '/'));
            if (isset($pathArr[0])) {
                $this->ctrl = $pathArr[0];
            }
            if (isset($pathArr[1])) {
                $this->action = $pathArr[1];
            } else {
                $this->action = 'index';
            }
            //url 多余部分转换为 get 参数
            $count = count($pathArr) + 2;
            $i = 2;
            while ($i < $count) {
                if (isset($pathArr[$i + 1])) {
                    $_GET[$pathArr[$i]] = $pathArr[$i + 1];
                }
                $i = $i + 2;
            }
        } else {
            $this->ctrl = 'index';
            $this->action = 'index';
        }
    }
}
