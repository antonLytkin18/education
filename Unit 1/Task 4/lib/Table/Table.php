<?php
/**
 * @author Anton Lytkin <anton.lytkin18@gmail.com>
 */

namespace WS\Table;

use WS\ActiveRecord\ActiveRecord;

class Table {

    private static $instance;
    /**
     * @var TableData
     */
    private $tableData;

    private function __construct() {}

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function setTable(ActiveRecord $entity) {
        $this->tableData = new TableData($entity);
    }

    /**
     * @return array
     */
    public function getProperties() {
        return $this->tableData->getProperties();
    }

    /**
     * @param string $name
     *
     * @return string
     */
    public function getFieldByEntityName($name) {
        $properties = $this->tableData->getProperties();
        return $properties[$name];
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->tableData->getTableName();
    }
}