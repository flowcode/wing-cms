<?php

namespace flowcode\cms\domain;

use flowcode\cms\service\RoleService;
use flowcode\wing\mvc\Entity;

/**
 * Description of Role
 *
 * @author Juan Manuel Agüero <jaguero@flowcode.com.ar>
 */
class Role extends Entity {

    private $name;
    private $permissions;

    function __construct() {
        parent::__construct();
        $this->permissions = NULL;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getPermissions() {
        if ($this->permissions == NULL) {
            $roleSrv = new RoleService();
            $this->permissions = $roleSrv->findPermissions($this);
        }
        return $this->permissions;
    }

    public function setPermissions($permissions) {
        $this->permissions = $permissions;
    }

    public function __toString() {
        return $this->name;
    }

}

?>
