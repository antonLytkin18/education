<?php
/**
 * @author Anton Lytkin <anton.lytkin18@gmail.com>
 */

namespace WS\Table;

use WS\ActiveRecord\ActiveRecord;

class TableData {

    const PROPERTY_DOC_NAME = 'property';
    const TABLE_DOC_NAME = 'table';

    private $properties;
    private $table;

    /**
     * @var ActiveRecord
     */
    private $entity;

    public function __construct(ActiveRecord $entity) {
        $this->entity = $entity;
        $this->setTableData();
    }

    private function setTableData() {
        $reflection = new \ReflectionClass($this->entity);
        $docBlock = $reflection->getDocComment();
        $strings = preg_split('/[\r\n]+/', $docBlock, -1, PREG_SPLIT_NO_EMPTY);
        while ($string = array_shift($strings)) {
            $stringWords = array_values(array_filter(explode(' ', $string)));
            if ($stringWords[0] == '*') {
                array_shift($stringWords);
            }
            if (substr($stringWords[0], 0, 1) !== '@') {
                continue;
            }
            $name = substr($stringWords[0], 1);
            $first = $stringWords[1];
            $array = '';
            if (substr($first, -2) == '[]') {
                $array = '[]';
                $first = substr($first, 0, -2);
            }
            $second = $stringWords[2];
            $third = $stringWords[3];
            $lineData = array($first, $second, $array, $third);

            if ($name == self::PROPERTY_DOC_NAME) {
                $propertyName = trim($lineData[1], '$');
                $this->properties[$propertyName] = $lineData[3];
            } elseif ($name == self::TABLE_DOC_NAME) {
                $this->table = $lineData[0];
            }
        }
    }

    /**
     * @return array
     */
    public function getProperties() {
        return $this->properties;
    }

    /**
     * @return string
     */
    public function getTableName() {
        return $this->table;
    }

    public function prepareFields($field, $value) {

    }
}