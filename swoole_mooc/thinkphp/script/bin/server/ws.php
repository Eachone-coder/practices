<?php
/**
 * User: zjx
 * Date: 2018/6/26
 * Time: 22:03
 */

use app\common\lib\redis\Predis;
use app\common\lib\task\Task;

class Ws
{
    CONST HOST = "0.0.0.0";
    CONST PORT = 8811;
    CONST CHART_PORT = 8812;

    public $ws = null;

    public function __construct()
    {
        $this->ws = new swoole_websocket_server(self::HOST, self::PORT);

        $this->ws->listen(self::HOST, self::CHART_PORT, SWOOLE_SOCK_TCP);

        $this->ws->set([
            'enable_static_handler' => true,
            'document_root' => '/home/vagrant/Code/swoole_mooc/thinkphp/public/static',
            'worker_num' => 4,
            'task_worker_num' => 4,
        ]);

        $this->ws->on("start", [$this, 'onStart']);
        $this->ws->on("open", [$this, 'onOpen']);
        $this->ws->on("message", [$this, 'onMessage']);
        $this->ws->on("workerstart", [$this, 'onWorkerStart']);
        $this->ws->on("request", [$this, 'onRequest']);
        $this->ws->on("task", [$this, 'onTask']);
        $this->ws->on("finish", [$this, 'onFinish']);
        $this->ws->on("close", [$this, 'onClose']);

        $this->ws->start();
    }

    public function onStart()
    {
        swoole_set_process_name('live_master');
    }
    /**
     * 监听 ws 连接事件
     *
     * @param $ws
     * @param $request
     * @throws Exception
     */
    public function onOpen($ws, $request)
    {
        var_dump($request->fd);
        Predis::getInstance()->sAdd(config('redis.live_game_key'), $request->fd);
    }

    /**
     * 监听 ws 消息事件
     * @param $ws
     * @param $frame
     */
    public function onMessage($ws, $frame)
    {
        echo "ser-push-message:{$frame->data}" . PHP_EOL;
        $ws->push($frame->fd, "server-push:" . date('Y-m-d H:i:s'));
    }

    public function onWorkerStart($server, $worker_id)
    {
        // 定义应用目录
        define('APP_PATH', __DIR__ . '/../../../application/');
        // 加载框架引导文件
        // require __DIR__ . '/../../../thinkphp/base.php';
        require __DIR__ . '/../../../thinkphp/start.php';
    }


    public function onRequest($request, $response)
    {

        if($request->server['request_uri'] == '/favicon.ico'){
            $response->status(4040);
            $response->end();
            return ;
        }

        $_SERVER = [];
        if (isset($request->server)) {
            foreach ($request->server as $k => $v) {
                $_SERVER[strtoupper($k)] = $v;
            }
        }
        $_GET = [];
        if (isset($request->get)) {
            foreach ($request->get as $k => $v) {
                $_GET[$k] = $v;
            }
        }

        $_FILES = [];
        if (isset($request->files)) {
            foreach ($request->files as $k => $v) {
                $_FILES[$k] = $v;
            }
        }

        $_POST = [];
        if (isset($request->post)) {
            foreach ($request->post as $k => $v) {
                $_POST[$k] = $v;
            }
        }
        $this->writeLog();
        $_POST['http_server'] = $this->ws;

        ob_start();
        // 执行应用并响应

        try {
            think\Container::get('app', [APP_PATH])
                ->run()
                ->send();
        } catch (\Exception $e) {

        }
        // echo "-action-" . request()->action() . PHP_EOL;
        $res = ob_get_contents();
        ob_end_clean();
        $response->end($res);
    }

    public function onTask($serv, $taskId, $workerId, $data)
    {

        // 分发 task 任务机制，让不同任务走不同逻辑
        $obj = new Task;

        $method = $data['method'];
        $flag = $obj->$method($data['data'], $serv);

        return $flag;
        // print_r($data);
        // sleep(10);
        // return "on task finish";
    }

    public function onFinish($serv, $taskId, $data)
    {
        echo "taskId:{$taskId}" . PHP_EOL;
        echo "finish-data-success:{$data}" . PHP_EOL;
    }

    /**
     * @param $ws
     * @param $fd
     * @throws Exception
     */
    public function onClose($ws, $fd)
    {
        echo "clientid:{$fd}" . PHP_EOL;
        Predis::getInstance()->sRem(config('redis.live_game_key'), $fd);
    }

    /**
     * 日志
     */
    public function writeLog()
    {
        $datas = array_merge(['date' => date('Y-m-d H:i:s')], $_GET, $_POST, $_SERVER);

        $logs = "";

        foreach ($datas as $key => $value) {
            $logs = $key . ":" . $value . "  ";
        }

        swoole_async_writefile(APP_PATH . "../runtime/log/" . date('Ym') . "/" . date("d") . "_access_log", $logs.PHP_EOL, function($filename){

        }, FILE_APPEND);
    }
}


new Ws();