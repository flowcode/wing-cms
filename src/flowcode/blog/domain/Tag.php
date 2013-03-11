<?php

namespace flowcode\blog\domain;

use flowcode\wing\mvc\Entity;

/**
 * Description of Tag
 *
 * @author juanma
 */
class Tag extends Entity {

    private $name;

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function __toString() {
        return $this->name;
    }

}

?>
