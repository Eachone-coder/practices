<?php
if (!function_exists('requests')) {
    /**
     * 获取请求信息
     *
     * @Author   zjx
     * @DateTime 2017-11-30T11:04:30+0800
     * @return   [type]                   [description]
     */
    function requests()
    {
        return Yii::$app->request();
    }
}

if (!function_exists('post_info')) {
    /**
     * 获取post信息
     *
     * @Author   zjx
     * @DateTime 2017-11-30T10:48:22+0800
     * @return   [type]                   [description]
     */
    function post_info($key = null, $default = false)
    {
        if ($key === null) {
            return Yii::$app->request->post();
        } else {
            return Yii::$app->request->post($key, $default);
        }
    }
}

if (!function_exists('get_info')) {
    /**
     * 获取get信息
     * @auther zjx
     * @date   2017-11-30
     * @param  [type]     $key [description]
     * @return [type]          [description]
     */
    function get_info($key = null, $default = false)
    {
        if ($key === null) {
            return Yii::$app->request->get();
        } else {
            return Yii::$app->request->get($key, $default);
        }
    }
}

if (!function_exists('is_post')) {
    /**
     * 判断是否是post方式传递
     *
     * @Author   zjx
     * @DateTime 2017-11-30T10:48:41+0800
     * @return   boolean                  [description]
     */
    function is_post()
    {
        return Yii::$app->request->isPost;
    }
}

if (!function_exists('is_get')) {
    /**
     * 判断是否是get方式传递
     * @auther zjx
     * @date   2017-12-04
     * @return boolean    [description]
     */
    function is_get()
    {
        return Yii::$app->request->isGet;
    }
}

if (!function_exists('is_ajax')) {
    /**
     * 判断是否是ajax方式提交
     * @auther zjx
     * @date   2017-12-04
     * @return boolean    [description]
     */
    function is_ajax()
    {
        return Yii::$app->request->isAjax;
    }
}

if (!function_exists('dump')) {
    /**
     * 格式化输出
     *
     * @Author   zjx
     * @DateTime 2017-11-30T10:51:44+0800
     * @param    [type]                   $data [description]
     * @return   [type]                         [description]
     */
    function dump($data)
    {
        echo '<pre>';
        var_dump($data);
    }
}

if (!function_exists('dd')) {
    /**
     * 格式化输出并终止程序
     *
     * @Author   zjx
     * @DateTime 2017-11-30T10:52:50+0800
     * @param    [type]                   $data [description]
     * @return   [type]                         [description]
     */
    function dd($data)
    {
        echo '<pre>';
        var_dump($data);
        die;
    }
}
