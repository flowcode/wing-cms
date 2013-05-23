<?php

namespace flowcode\cms\service;

use flowcode\cms\dao\PermissionDao;
use flowcode\cms\domain\Permission;

/**
 * 
 */
class PermissionService {

    private $permissionDao;

    function __construct() {
        $this->permissionDao = new PermissionDao();
    }

    /**
     * Funcion que guarda una Permission.
     * @param type $titulo
     * @param type $descipcion
     * @return type 
     */
    public function save($permission) {
        $id = $this->permissionDao->save($permission);
        return $id;
    }

    /**
     * Get all permissions.
     * @return array $permissions.
     */
    public function findAll() {
        $permissions = $this->permissionDao->findAll();
        return $permissions;
    }

    /**
     * Return a permissionr.
     * @param type $filter
     * @param type $permission
     * @return Permissionr $permissionr.
     */
    public function findByFilter($filter = null, $permission = 1) {
        $permissionr = $this->permissionDao->findByFilter($filter, $permission);
        return $permissionr;
    }

    public function findById($id) {
        $entity = NULL;
        if (strlen($id) > 0) {
            $entity = $this->permissionDao->findById($id);
        }
        return $entity;
    }

    public function delete(Permission $permission) {
        $this->permissionDao->delete($permission);
    }

}

?>
