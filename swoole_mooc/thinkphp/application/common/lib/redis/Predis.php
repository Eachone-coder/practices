<?php
/**
 * User: zjx
 * Date: 2018/6/29
 * Time: 20:59
 */

namespace app\common\lib\redis;

class Predis
{

    private $redis = '';

    private static $_instance = null;

    /**
     * 单例
     *
     * @return Predis|null
     * @throws \Exception
     */
    public static function getInstance()
    {
        if (empty(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    private function __construct()
    {
        $this->redis = new \Redis();
        $result = $this->redis->connect(config('redis.host'), config('redis.port'), config('redis.timeout'));
        if ($result === false) {
            throw new \Exception('redis connect error');
        }
    }

    /**
     * @param $key
     * @param $value
     * @param int $time
     * @return bool|string
     */
    public function set($key, $value, $time = 0)
    {
        if (!$key) {
            return '';
        }

        if (is_array($value)) {
            $value = json_encode($value);
        }

        if (!$time) {
            return $this->redis->set($key, $value);
        }

        return $this->redis->setex($key, $time, $value);
    }

    /**
     * @param $key
     * @return bool|string
     */
    public function get($key)
    {
        if (!$key) {
            return '';
        }

        return $this->redis->get($key);
    }

    /**
     *
     * @param $key
     * @param $valuse
     * @return mixed
     */
    public function sAdd($key, $value)
    {
        return $this->redis->sAdd($key, $value);
    }

    /**
     * @param $key
     * @param $value
     * @return int
     */
    public function sRem($key, $value)
    {
        return $this->redis->sRem($key, $value);
    }

    /**
     * @param $key
     * @return array
     */
    public function sMembers($key)
    {
        return $this->redis->sMembers($key);
    }

}