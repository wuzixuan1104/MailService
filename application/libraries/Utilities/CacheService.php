<?php
namespace Utilities;

/**
 * Cache Service Provider
 *
 * @author Jun Lin <xuanjunlin@gmail.com>
 * @link http://www.tripresso.com/
 */

class CacheService
{
    const TTL = 86400;
    private $redis_db;
    private $drive = 'redis';
    public $CI;
    private $_config;
    public $db;

    /**
     * 檢查設定是否使用 redis 或 ci 是否support redis
     * @return [type] [description]
     */
    public function checkEnabled()
    {
        if (empty($this->_config['redis_default']['enabled']) || !$this->_config['redis_default']['enabled'] ) {
            log_message('info', 'Not enabled CI Redis');
            return false;
        }

        if (!$this->CI->cache->redis->is_supported()) {
            log_message('info', 'Not support redis of CI, please install redis driver for CI.');
            return false;
        }
        return true;
    }

    public function init(&$CI, $redis_db = 1)
    {
        $this->CI = $CI;
        $this->CI->load->driver('cache', array('adapter' => $this->drive));

        if ($redis_db !=1) {
            $this->redis_db = $redis_db;
        } else {
            if ($this->CI->config->load('redis', TRUE, TRUE))
            {
                $this->_config = $this->CI->config->item('redis');
                $redis_db = $this->_config['redis_default']['database'];
            }
        }
        $this->redis_db = $redis_db;
    }

    public function cleanByKey($cacheKey)
    {
        if (!$this->checkEnabled()) {
            return false;
        }

        if ($res = $this->CI->cache->redis->keys($cacheKey.'*', $this->redis_db)) {
            foreach ($res as $val) {
                if (!$this->CI->cache->redis->delete($val, $this->redis_db)) {
                    log_message('warning', $val.' remove failed');
                }
            }
        }
        if(!$this->CI->cache->redis->delete($cacheKey, $this->redis_db)){
            log_message('warning', $cacheKey.' remove failed');
            return false;
        }
        return true;
    }

    /**
     * MethodCached
     *
     * @param  [string]   $cacheKey
     * @param  [function] $method
     * @param  [array]    $args
     * @param  [integer]  $ttl
     * @return [array]
     */
    public function run($cacheKey, $doing, $args = array(),  $ttl = self::TTL)
    {
        if (!$this->checkEnabled()) {
            $res = $doing($args);
            return $res;
        }

        $res = array();

        if ($ttl == -1) {
            $this->cleanByKey($cacheKey);
        }

        $data = $this->CI->cache->redis->get($cacheKey, $this->redis_db);

        if ($data) {
            $res = $data;
        } else {
            $res = $doing($args);
            $this->CI->cache->redis->save($cacheKey, $res, $ttl, false, $this->redis_db);
        }
        return $res;
    }

    public function get($cacheKey)
    {
        if (!$this->checkEnabled()) {
            return false;
        }

        if ($val = $this->CI->cache->redis->get($cacheKey, $this->redis_db)) {
            return $val;
        }
        return false;
    }

    public function save($cacheKey, $res, $ttl = self::TTL)
    {
        if (!$this->checkEnabled()) {
            return false;
        }

        if ($this->CI->cache->redis->save($cacheKey, $res, $ttl, false, $this->redis_db)) {
            return true;
        }
        return false;
    }

    public function getByKeys($cacheKey)
    {
        if (!$this->checkEnabled()) {
            return false;
        }

        if ($val = $this->CI->cache->redis->getByKeys($cacheKey, $this->redis_db)) {
            return $val;
        }
        return false;
    }
}
