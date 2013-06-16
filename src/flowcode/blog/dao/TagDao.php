<?php

namespace flowcode\blog\dao;

use flowcode\blog\domain\Tag;
use flowcode\orm\EntityManager;

/**
 * Description of TagDao
 *
 * @author juanma
 */
class TagDao {

    public function __construct() {
        
    }

    public function save(Tag $tag) {
        EntityManager::getInstance()->save($tag);
    }

    public function findAll() {
        return EntityManager::getInstance()->findAll("tag");
    }

    public function delete(Tag $tag) {
        EntityManager::getInstance()->delete($tag);
    }

    public function findById($id) {
        return EntityManager::getInstance()->findById("tag", $id);
    }

    public function findByFilter($filter = null, $page = 1) {
        $em = EntityManager::getInstance();
        $pager = $em->findByGenericFilter("tag", $filter, $page);
        return $pager;
    }

}

?>
