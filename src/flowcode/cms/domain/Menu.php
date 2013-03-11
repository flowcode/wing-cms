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
        $this->items = array();
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getItems() {
        return $this->items;
    }

    public function setItems($items) {
        $this->items = $items;
    }

}

?>
