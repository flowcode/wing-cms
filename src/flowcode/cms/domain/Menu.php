<?php

namespace flowcode\cms\domain;

use flowcode\wing\mvc\Entity;

/**
 * Description of Menu
 *
 * @author juanma
 */
class Menu extends Entity {

    private $name;
    private $items = null;

    public function __construct() {
        parent::__construct();
        $this->items = NULL;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getItems() {
        if (is_null($this->items)) {
            $itemMenuSrv = new \flowcode\cms\service\ItemMenuService();
            $this->items = $itemMenuSrv->findByMenu($this);
        }
        return $this->items;
    }

    public function setItems($items) {
        $this->items = $items;
    }

    public function getMainItems() {
        $itemMenuSrv = new \flowcode\cms\service\ItemMenuService();
        return $itemMenuSrv->findFathersByMenu($this);
    }

}

?>
