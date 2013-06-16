<?php

namespace flowcode\cms\service;

use flowcode\cms\dao\UserDao;
use flowcode\cms\domain\User;
use flowcode\wing\mvc\Config;

/**
 * @author Juan Manuel Aguero.
 */
class UserService {

    private $userDao;

    function __construct() {
        $this->userDao = new UserDao();
    }

    /**
     * Funcion que guarda un Usuario.
     * 
     * @return type id.
     */
    public function save(User $usuario) {
        $usuario->setPassword($this->encodePass($usuario->getPassword()));
        $id = $this->userDao->save($usuario);

        return $id;
    }

    private function encodePass($pass) {
        $encoded = sha1($pass);
        return $encoded;
    }

    public function modificarUsuario($usuario, $alterPass = FALSE) {
        if ($alterPass) {
            $usuario->setPassword($this->encodePass($usuario->getPassword()));
        }
        $id = $this->userDao->save($usuario);
        return $id;
    }

    /**
     * Realiza la validacion y el login del usuario. 
     * Returna n valor de acuerdo a si fue correcto o no.
     * @param type $username
     * @param type $password
     * @return boolean 
     */
    public function loginUsuario($username, $password) {
        $valido = FALSE;

        if (strlen($username) > 0 && strlen($password) > 0) {
            $usuario = $this->getUserByUsernamePassword($username, $password);
            if ($usuario != null) {
                $this->authenticateUser($usuario);
                $valido = TRUE;
            }
        }
        return $valido;
    }

    /**
     * Obtiene un usuario.
     * @return User. 
     */
    public function getUserByUsernamePassword($username, $password) {
        $encodedPass = $this->encodePass($password);
        $usuario = $this->userDao->getUserByUsernamePassword($username, $encodedPass);
        return $usuario;
    }

    /**
     * Obtiene un usuario.
     * @return type 
     */
    public function obtenerUsuarioPorUsername($username) {
        $usuario = $this->userDao->obtenerUsuarioPorUsername($username);
        return $usuario;
    }

    /**
     * Obtiene un usuario de acuero al id.
     * @return type 
     */
    public function obtenerUsuarioPorId($id) {
        $usuario = $this->userDao->obtenerUsuarioPorId($id);
        return $usuario;
    }

    /**
     * Obtiene todos los usuarios del sistema.
     * @return type 
     */
    public function obtenerUsuariosTodos() {
        return $this->userDao->obternerUsuariosTodos();
    }

    public function obtenerUsuariosFiltrados($pagina = 1, $filtro = null) {
        $pager = null;
        $pager = null;
        $cantSlotsPorPagina = Config::get('listados', 'usuarios_por_pagina');

        $data = $this->userDao->obtenerUsuariosFiltro($pagina - 1, $filtro);

        $total = $this->userDao->obtenerTotalUsuariosFiltro($filtro);
        $cantidadPaginas = ceil($total / $cantSlotsPorPagina);

        $pager['data'] = $data;
        $pager['total'] = $total;
        $pager['page-count'] = $cantidadPaginas;
        $pager['prev'] = ($pagina > 1) ? $pagina - 1 : $pagina;
        $pager['next'] = ($pagina < $cantidadPaginas) ? $pagina + 1 : $pagina;

        return $pager;
    }

    /**
     * Elimina un usuario por su id.
     * @param type $id 
     */
    public function eliminarUsuarioPorId($id) {
        $this->userDao->eliminarUsuarioPorId($id);
    }

    /**
     * Authentica un usuario en la sesion.
     * @param type $user 
     */
    public function authenticateUser($user) {
        if ($user->getUsername() != "") {
            $_SESSION['user']['username'] = $user->getUsername();
        }
        foreach ($user->getRoles() as $role) {
            foreach ($role->getPermissions() as $permission) {
                $_SESSION['user']['roles'][$role->getName()]["permissions"][] = $permission->getName();
            }
        }
    }

    public function findByFilter($filter = null, $page = 1) {
        $pager = $this->userDao->findByFilter($filter, $page);
        return $pager;
    }

    public function getUserDao() {
        return $this->userDao;
    }

    public function setUserDao($userDao) {
        $this->userDao = $userDao;
    }

    public function findRoles(User $user) {
        return $this->userDao->findRoles($user);
    }

}

?>
