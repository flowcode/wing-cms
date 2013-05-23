<?php

namespace flowcode\cms\dao;

use flowcode\cms\domain\Role;
use flowcode\orm\EntityManager;

/**
 * Description of RoleDao
 *
 * @author Juanma.
 */
class RoleDao {

    public function __construct() {
        
    }

    public function save(Role $role) {
        $em = EntityManager::getInstance();
        $em->save($role);
    }

    function delete(Role $role) {
        $em = EntityManager::getInstance();
        $em->delete($role);
    }

    public function findById($id) {
        $em = EntityManager::getInstance();
        return $em->findById("role", $id);
    }

    public function findAll() {
        $em = EntityManager::getInstance();
        return $em->findAll("role");
    }

    public function findPermissions(Role $role) {
        $em = EntityManager::getInstance();
        $permissions = $em->findRelation($role, "Permissions");
        return $permissions;
    }

    /**
     * Return an active roler.
     * @param type $filter
     * @param type $role
     * @return Roler $roler.
     */
    public function findByFilter($filter = null, $role = 1) {
        $em = EntityManager::getInstance();
        $roler = $em->findByGenericFilter("role", $filter, $role, "name", "asc");
        return $roler;
    }

}

?>
