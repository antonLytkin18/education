<?php
/**
 * @author Anton Lytkin <anton.lytkin18@gmail.com>
 */

namespace WS\ResultCache;

use mysqli_result;

class ResultCache {

    private static $instance;

    /**
     * @var mysqli_result[]
     */
    private $data;

    private function __construct() {
        $this->data = array();
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * @param $queryString
     *
     * @return bool|mysqli_result
     */
    public function get($queryString) {
        $cacheKey = md5($queryString);
        if ($cachedResult = $this->data[$cacheKey]) {
            return $cachedResult;
        }
        return false;
    }

    /**
     * @param string $queryString
     *
     * @param mysqli_result $result
     */
    public function set($queryString, $result) {
        $cacheKey = md5($queryString);
        $this->data[$cacheKey] = $result;
    }
}