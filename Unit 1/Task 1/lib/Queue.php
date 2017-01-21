<?php
/**
 * @author Maxim Sokolovsky <sokolovsky@worksolutions.ru>
 */

namespace WS\Education\Unit1\Task1;

class Queue implements Collection {

    private $data;

    public function __construct($type = null) {
        $this->data = array();
    }

    public function pop() {
        return array_shift($this->data);
    }

    public function size() {
        return count($this->data);
    }

    public function push($el) {
       array_push($this->data, $el);
    }
}