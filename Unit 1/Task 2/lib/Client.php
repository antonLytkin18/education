<?php

namespace WS\Education\Unit1\Task2;

/**
 * @author Maxim Sokolovsky <sokolovsky@worksolutions.ru>
 */

class Client {

    /**
     * @var Connection
     */
    private $connection;
    private $host;
    private $port;
    private $timeout;

    public function __construct($host, $port, $timeout) {
        $this->host = $host;
        $this->port = $port;
        $this->timeout = $timeout;
        $this->initConnection();
    }

    private function initConnection() {
        $resource = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if (!$resource) {
            throw new \RuntimeException(socket_strerror(socket_last_error($resource)));
        }
        socket_set_option($resource, SOL_SOCKET, SO_SNDTIMEO, array(
            'sec' => $this->timeout,
            'usec' => null
        ));
        $isSuccessConnect = socket_connect($resource, $this->host, $this->port);
        if (!$isSuccessConnect) {
            throw new \RuntimeException(socket_strerror(socket_last_error($resource)));
        }
        $this->connection = new Connection($resource);
    }

    /**
     * @param int $strNumber
     */
    public function send($strNumber) {
        $this->connection->write($strNumber);
    }

    /**
     * @return string
     */
    public function receive() {
        return $this->connection->read();
    }

    public function close() {
        $this->connection->close();
    }
}