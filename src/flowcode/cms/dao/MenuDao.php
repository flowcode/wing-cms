<?php

namespace flowcode\cms\dao;

use flowcode\cms\domain\Menu;
use flowcode\orm\EntityManager;

class MenuDao {

    public function __construct() {
        
    }

    /**
     * Guarda o modifica la menu recibida por parametro.
     * @param type $menu
     * @return type 
     */
    function save(Menu $menu) {
        $em = EntityManager::getInstance();
        $id = $em->save($menu);
        return $id;
    }

    /**
     * Find a menu by its id.
     * @param type $id
     * @return Menu
     */
    function findById($id) {
        $em = EntityManager::getInstance();
        $menu = $em->findById("menu", $id);
        return $menu;
    }

    /**
     * Find all system menus.
     * @return type
     */
    function findAll() {
        $em = EntityManager::getInstance();
        $menus = $em->findAll("menu");
        return $menus;
    }

}