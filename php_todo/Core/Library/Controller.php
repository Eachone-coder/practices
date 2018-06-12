<?php
namespace Core\Library;

/**
 * 基础控制器
 */
class Controller
{
    protected $data = [];

    public function __construct()
    {
        $this->init();
    }

    public function init()
    {
    }
    /**
     * ajax返回数据到客户端
     * @auther zjx
     * @date   2017-12-06
     * @param  mixed     $data 返回的数据
     * @param  string     $type 数据格式
     * @return void
     */
    public function ajaxReturn($data, $type='JSON')
    {
        switch (strtoupper($type)) {
            case 'JSON':
                // 返回JSON数据格式到客户端 包含状态信息
                header('Content-Type:application/json; charset=utf-8');
                exit(json_encode($data));
            case 'XML':
                // 返回xml格式数据
                header('Content-Type:text/xml; charset=utf-8');
                exit(xml_encode($data));
            case 'JSONP':
                // 返回JSON数据格式到客户端 包含状态信息
                header('Content-Type:application/json; charset=utf-8');
                $handler  =   isset($_GET[C('VAR_JSONP_HANDLER')]) ? $_GET[C('VAR_JSONP_HANDLER')] : C('DEFAULT_JSONP_HANDLER');
                exit($handler.'('.json_encode($data).');');
            case 'EVAL':
                // 返回可执行的js脚本
                header('Content-Type:text/html; charset=utf-8');
                exit($data);
            default:
                // 用于扩展其他返回格式数据
                Hook::listen('ajax_return', $data);
        }
    }
    /**
     * 返回成功信息到客户端
     * @auther zjx
     * @date   2017-12-06
     * @param  mixed     $info
     * @return void
     */
    public function success($info)
    {
        $data['status'] = 1;
        $data['info'] = $info;
        $this->ajaxReturn($data);
    }

    /**
     * 返回错误信息到客户端
     * @auther zjx
     * @date   2017-12-06
     * @param  mixed     $info
     * @return void
     */
    public function error($info)
    {
        $data['status'] = 0;
        $data['info'] = $info;
        $this->ajaxReturn($data);
    }

    protected function display($templateFile=null)
    {
        if (is_null($templateFile)) {
            $file = VIEW_PATH.CONTROLLER_NAME.DS.ACTION_NAME.'.php';
        } else {
            $file = VIEW_PATH.CONTROLLER_NAME.DS.$templateFile.'.php';
        }
        if (is_file($file)) {
            extract($this->data);
            include $file;
        } else {
            throw new Exception("模版文件未找到");
        }
    }
    protected function assign($name, $value)
    {
        $this->data[$name] = $value;
    }
}
