<?php
/**
 * @author Maxim Sokolovsky <sokolovsky@worksolutions.ru>
 */

namespace WS\Education\Unit1\Task1;

class Stack implements Collection {

    private $data;

    public function __construct($type = null) {
        $this->data = array();
    }

    public function push($el) {
        array_push($this->data, $el);
    }

    public function size() {
        return count($this->data);
    }

    public function pop() {
        return array_pop($this->data);
    }
}