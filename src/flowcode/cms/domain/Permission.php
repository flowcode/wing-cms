<?php

namespace flowcode\cms\domain;

use flowcode\wing\mvc\Entity;

/**
 * Description of Permission
 *
 * @author Juan Manuel Agüero <jaguero@flowcode.com.ar>
 */
class Permission extends Entity {

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
