<?php
/**
 * @author Anton Lytkin <anton.lytkin18@gmail.com>
 */

namespace WS\DataBase;

use mysqli;

class DataBase {

    private $host;
    private $user;
    private $password;
    private $dbName;

    private static $instance;

    /**
     * @var mysqli
     */
    private $connection;

    private function __construct() {}

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function initConnection() {
        $this->connection = new mysqli($this->host, $this->user, $this->password, $this->dbName);
        if ($this->connection->connect_error) {
            throw new \Exception($this->connection->connect_error);
        }
    }

    public function setConfig(array $config) {
        $this->host = $config['host'];
        $this->user = $config['user'];
        $this->password = $config['password'];
        $this->dbName = $config['dbName'];
        $this->initConnection();
    }

    /**
     * @param $queryString
     *
     * @return bool|\mysqli_result
     */
    public function query($queryString) {
        $result = $this->connection->query($queryString);
        if (!$result) {
            throw new \RuntimeException($this->connection->error);
        }
        return $result;
    }
}