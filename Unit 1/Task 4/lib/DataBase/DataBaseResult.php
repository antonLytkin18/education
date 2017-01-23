<?php
/**
 * @author Anton Lytkin <anton.lytkin18@gmail.com>
 */

namespace WS\DataBase;

use WS\ActiveRecord\ActiveRecord;
use WS\ResultCache\ResultCache;

class DataBaseResult {

    /**
     * @var ActiveRecord
     */
    private $entity;

    /**
     * @var bool|\mysqli_result
     */
    private $result;

    /**
     * @var ResultCache
     */
    private $resultCache;

    public function __construct(ActiveRecord $entity, $queryString) {
        $this->resultCache = ResultCache::getInstance();
        $this->entity = $entity;
        if ($result = $this->resultCache->get($queryString)) {
            $this->result = $result;
        } else {
            $this->result = DataBase::getInstance()->query($queryString);
            $this->resultCache->set($queryString, $this->result);
        }
    }

    /**
     * @return ActiveRecord|bool
     */
    public function fetch() {
        $resultArray = $this->result->fetch_assoc();
        $this->entity->setPropertyValues($resultArray);
        return $this->entity;
    }
}