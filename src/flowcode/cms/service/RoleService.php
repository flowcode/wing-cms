<?php

namespace flowcode\cms\service;

use flowcode\cms\dao\RoleDao;
use flowcode\cms\domain\Role;

/**
 * 
 */
class RoleService {

    private $roleDao;

    function __construct() {
        $this->roleDao = new RoleDao();
    }

    /**
     * Funcion que guarda una Role.
     * @param type $titulo
     * @param type $descipcion
     * @return type 
     */
    public function save($role) {
        $id = $this->roleDao->save($role);
        return $id;
    }

    /**
     * Get all roles.
     * @return array $roles.
     */
    public function findAll() {
        $roles = $this->roleDao->findAll();
        return $roles;
    }

    /**
     * Return a roler.
     * @param type $filter
     * @param type $role
     * @return Roler $roler.
     */
    public function findByFilter($filter = null, $role = 1) {
        $roler = $this->roleDao->findByFilter($filter, $role);
        return $roler;
    }

    public function findById($id) {
        $entity = NULL;
        if (strlen($id) > 0) {
            $entity = $this->roleDao->findById($id);
        }
        return $entity;
    }

    public function delete(Role $role) {
        $this->roleDao->delete($role);
    }

    public function findPermissions(Role $role) {
        return $this->roleDao->findPermissions($role);
    }

}

?>
