<?php

use WS\Entity\Movies;

class ActiveRecordTest extends PHPUnit_Framework_TestCase {

    public function testAddRow() {
        $movies = new Movies();
        $movies->name = 'Test Name';
        $movies->author = 'Test Author';
        $movies->description = 'Test Descr';
        $result = $movies->save();
        $this->assertEquals($result, true);
    }

    public function testFind() {
        $movies = new Movies();
        $movies->name = 'Test Name';
        $movies->description = 'Test Descr';
        $movies->find()->fetch();
        $this->assertEquals($movies->author, 'Test Author');
    }

    public function testDelete() {
        $movies = new Movies();
        $movies->id = 1;
        $result = $movies->delete();
        $this->assertEquals($result, true);
    }
}
