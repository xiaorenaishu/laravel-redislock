<?php
/**
 * 分布式上锁工具类
 * User: cxr
 * Date: 2019-06-05
 * Time: 17:24
 */

namespace RedisLock;

use Illuminate\Support\Facades\Redis;

class DistributedLock
{
    private static $uniqid = '1'; //未防止异端删key增加请求唯一标示

    /**
     * 上锁
     * 保证原子性写操作
     * @param String $key 上锁key
     * @param int $lockExpire 过期时间
     * @param string $connection 可指定链接串
     * @return bool
     */
    public static function lock($key, $lockExpire = 3, $connection = 'default')
    {
        self::$uniqid = uniqid();
        $result = Redis::connection($connection)->set($key, self::$uniqid, 'EX', $lockExpire, 'NX');
        return !is_null($result);
    }

    /**
     * 解锁
     * 采用eval保证同端删除操作，保证原子性操作
     * @param $key
     * @param string $connection
     * @return bool
     */
    public static function unlock($key, $connection = 'default')
    {
        $luaScript = "if redis.call('get', KEYS[1]) == ARGV[1] then return redis.call('del', KEYS[1]) else return 0 end";
        $result = Redis::connection($connection)->eval($luaScript, 1, $key, self::$uniqid);
        return (bool)$result;
    }
}