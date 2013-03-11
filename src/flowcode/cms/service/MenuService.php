<?php

namespace flowcode\cms\service;

use flowcode\cms\dao\MenuDao;
use flowcode\cms\domain\Menu;

/**
 * 
 */
class MenuService {

    private $menuDao;

    function __construct() {
        $this->menuDao = new MenuDao();
    }

    /**
     * Funcion que guarda una Menu.
     * @param Menu $menu
     * @return type 
     */
    public function save($menu) {
        $id = $this->menuDao->save($menu);
        return $id;
    }

    /**
     * Obtiene todas las Menu.
     * @return type 
     */
    public function findAll() {
        $menus = $this->menuDao->findAll();
        return $menus;
    }

    public function findById($id) {
        $entidad = NULL;
        if (strlen($id) > 0) {
            $entidad = $this->menuDao->findById($id);
        }
        return $entidad;
    }

}

?>
