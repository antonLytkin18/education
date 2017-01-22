<?php
/**
 * @author Maxim Sokolovsky <sokolovsky@worksolutions.ru>
 */

namespace WS\Education\Unit1\Task2;

class Server {

    const IP_ADDRESS = '127.0.0.1';

    private $port;

    /**
     * @var callable
     */
    private $handler;
    /**
     * @var resource
     */
    private $resource;

    /**
     * Server constructor.
     *
     * @param int $port
     */
    public function __construct($port) {
        $this->port = $port;
        $this->initListenResource();
    }

    private function initListenResource() {
        $this->resource = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if (!$this->resource) {
            throw new \RuntimeException(socket_strerror(socket_last_error($this->resource)));
        }
        $isSuccessBind = socket_bind($this->resource, self::IP_ADDRESS, $this->port);
        if (!$isSuccessBind) {
            throw new \RuntimeException(socket_strerror(socket_last_error($this->resource)));
        }
        $isSuccessListen = socket_listen($this->resource);
        if (!$isSuccessListen) {
            throw new \RuntimeException(socket_strerror(socket_last_error($this->resource)));
        }
    }

    /**
     * @param callable $handler
     */
    public function registerHandler($handler) {
        if (!is_callable($handler)) {
            throw new \RuntimeException("Handler must be callable!");
        }
        $this->handler = $handler;
    }

    public function listen() {
        while ($connection = socket_accept($this->resource)) {
            call_user_func($this->handler, new Connection($connection));
        }
    }

    public function close() {
        socket_close($this->resource);
    }
}
