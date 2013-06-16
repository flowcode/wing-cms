<?php

namespace flowcode\cms\dao;

use flowcode\cms\domain\ItemMenu;
use flowcode\orm\EntityManager;

class ItemMenuDao {

    public function __construct() {
        
    }

    /**
     * Guarda o modifica la itemmenu recibida por parametro.
     * @param type $itemmenu
     * @return type 
     */
    function save(ItemMenu $itemMenu) {
        $em = EntityManager::getInstance();
        $id = $em->save($itemMenu);
        return $id;
    }

    /**
     * Obtiene una itemmenu por su id.
     * @param type $id
     * @return ItemMenu
     * @throws EntityDaoException 
     */
    function findById($id) {
        $em = EntityManager::getInstance();
        $itemMenu = $em->findById("itemmenu", $id);
        return $itemMenu;
    }

    /**
     * Obtienen las itemmenus.
     * @return type
     * @throws EntityDaoException 
     */
    function findAll() {
        $em = EntityManager::getInstance();
        return $em->findAll("itemmenu");
    }
    
    function findFathersByMenuId($menuId){
        $em = EntityManager::getInstance();
        $where = "id_father = '0' AND id_menu='$menuId'";
        return $em->findByWhereFilter("itemmenu", $where, "order");
    }

    /**
     * Obtiene los itemMenus de un menu.
     * @param type $menuId
     * @return type
     * @throws EntityDaoException 
     */
    function findByMenuId($menuId) {
        $em = EntityManager::getInstance();
        $where = "id_menu = '$menuId'";
        return $em->findByWhereFilter("itemmenu", $where, "order");
    }

    /**
     * Obtienen los itemMenus de un itemMenu padre.
     * @param Integer $padreId
     * @return Array itemMenus.
     * @throws EntityDaoException 
     */
    function findByFatherId($fatherId) {
        $em = EntityManager::getInstance();
        $where = "id_father = '$fatherId'";
        return $em->findByWhereFilter("itemmenu", $where, "order");
    }

    function delete(ItemMenu $itemMenu) {
        $em = EntityManager::getInstance();
        $em->delete($itemMenu);
    }

}