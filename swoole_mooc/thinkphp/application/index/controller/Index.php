<?php
/**
 * User: zjx
 * Date: 2018/6/27
 * Time: 21:55
 */

namespace app\index\controller;

class Index
{
    public function index()
    {
        print_r('index');
    }

    public function singwa()
    {
        print_r(time());
    }
}