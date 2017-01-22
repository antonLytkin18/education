<?php
/**
 * @author Maxim Sokolovsky <sokolovsky@worksolutions.ru>
 */

namespace WS\Education\Unit1\Task2;

class Connection {

    /**
     * @var resource
     */
    private $resource;

    /**
     * Connection constructor.
     *
     * @param resource $resource
     */
    public function __construct($resource) {
        $this->resource = $resource;
    }

    /**
     * @param int $length
     *
     * @return mixed
     */
    public function read($length = 1024) {
        $content = '';
        $isSuccessReceive = socket_recv($this->resource, $content, $length, 0);
        if (!$isSuccessReceive) {
            throw new \RuntimeException(socket_strerror(socket_last_error($this->resource)));
        }
        return $content;
    }

    /**
     * @param mixed $content
     */
    public function write($content) {
        $isSuccessWrite = socket_write($this->resource, $content);
        if (!$isSuccessWrite) {
            throw new \RuntimeException(socket_strerror(socket_last_error($this->resource)));
        }
    }

    public function close() {
        socket_close($this->resource);
    }
}