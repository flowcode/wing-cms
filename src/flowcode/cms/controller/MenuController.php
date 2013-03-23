<?php

namespace flowcode\cms\controller;

use flowcode\cms\domain\Menu;
use flowcode\cms\service\MenuService;

/**
 * Este controlador atiende los eventos del menu.
 *
 * @author juanma
 */
class MenuController {

    /**
     * Obtiene las noticias que se seleccionaron para ir en la barra de noticias.
     * @return Menu
     */
    public static function getMenu($id) {
        $menuService = new MenuService();
        $menu = $menuService->findById($id);
        return $menu;
    }

}

?>
