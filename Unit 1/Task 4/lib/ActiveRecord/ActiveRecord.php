<?php
/**
 * @author Anton Lytkin <anton.lytkin18@gmail.com>
 */

namespace WS\ActiveRecord;

use mysqli_result;
use WS\DataBase\DataBaseResult;
use WS\Table\Table;

abstract class ActiveRecord {

    /**
     * @var Table
     */
    private $table;
    protected $fields;
    protected $values;

    /**
     * @var mysqli_result $result
     */
    protected $result;

    public function __construct() {
        $this->table = Table::getInstance();
        $this->table->setTable($this);
    }

    /**
     * @param array $resultArray
     */
    public function setPropertyValues($resultArray) {
        if (empty($resultArray)) {
            return;
        }
        foreach($this->table->getProperties() as $property => $field) {
            if (!$resultArray[$field]) {
                continue;
            }
            $this->$property = $resultArray[$field];
        }
    }

    /**
     * @param string $query
     *
     * @return DataBaseResult
     */
    private function query($query) {
        $entity = get_called_class();
        return new DataBaseResult(new $entity(), $query);
    }

    /**
     * @return string
     */
    private function buildQueryString() {
        $queryString = "SELECT * FROM %s WHERE ";
        $arFields = array_combine($this->fields, $this->values);
        $iteration = 0;
        $fieldsCount = count($arFields);
        foreach($arFields as $field => $value) {
            $queryString .= $field . ' = ' . "'$value'";
            if ($iteration < $fieldsCount - 1) {
                $queryString .= ' AND ';
            }
            $iteration++;
        }
        return $queryString;
    }

    /**
     * @return DataBaseResult
     */
    public function find() {
        return $this->query(sprintf($this->buildQueryString(), $this->table->getName()));
    }

    /**
     * @return DataBaseResult
     */
    public function findAll() {
        $queryString = "SELECT * FROM %s";
        return $this->query(sprintf($queryString, $this->table->getName()));
    }

    /**
     * @return bool
     */
    public function save() {
        $queryString = "INSERT INTO %s(%s) VALUES(%s)";
        $fieldsString = implode(', ', $this->fields);
        $valuesString = "'" . implode("','", $this->values) . "'";
        $result = $this->query(sprintf($queryString, $this->table->getName(), $fieldsString, $valuesString));
        if (!$result) {
            return false;
        }
        return true;
    }

    /**
     * @return bool
     */
    public function delete() {
        if (!$this->id) {
            return false;
        }
        $queryString = "DELETE FROM %s WHERE id=%s";
        $result = $this->query(sprintf($queryString, $this->table->getName(), $this->id));
        if (!$result) {
            return false;
        }
        return true;
    }

    public function __get($field) {
        return $this->$field;
    }

    public function __set($field, $value) {
        $this->$field = $value;
        $this->fields[] = $this->table->getFieldByEntityName($field);
        $this->values[] = $value;
    }
}