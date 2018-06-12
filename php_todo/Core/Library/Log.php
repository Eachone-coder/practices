<?php
namespace Core\Library;

/**
 * Log日志类
 */
class Log
{
    /**
     * 写入
     * @auther zjx
     * @date   2017-12-07
     * @param  [type]     $content [description]
     * @param  [type]     $type    [description]
     * @return [type]              [description]
     */
    public static function write($content, $type, $level)
    {
        $file = LOG_PATH . date('Y-m-d') . '.log';
        $handle = fopen($file, 'a');
        $content = $level.'['.$type.']:'.date('Y-m-d H:i:s').'  '.$content . "\r\n";
        fwrite($handle, $content);
    }
}
