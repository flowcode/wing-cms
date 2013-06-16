<?php

namespace flowcode\cms\dao;

use Exception;
use flowcode\cms\domain\User;
use flowcode\orm\domain\Collection;
use flowcode\orm\EntityManager;
use flowcode\wing\mvc\DataSource;

/**
 * Engloba las operaciones de persistencia de un Usuario.
 *
 * @author Juan Manuel Aguero - http://juanmaaguero.com.ar .
 */
class UserDao {

    private $dataSource;

    public function __construct() {
        $this->dataSource = new DataSource();
    }

    /**
     * Metodo para guardar o modificar los datos de un usuario.
     * 
     * @param Categoria $categoria 
     */
    public function save($usuario) {
        $em = EntityManager::getInstance();
        return $em->save($usuario);
    }

    public function getUserByUsernamePassword($username, $password) {
        $user = null;
        $em = EntityManager::getInstance();
        $filter = "username = '" . $username . "' AND password = '" . $password . "'";
        $users = $em->findByWhereFilter("user", $filter);

        if ($users->count() > 0) {
            $users->rewind();
            $user = $users->current();
        }
        return $user;
    }

    /**
     * Obtiene un usuario por su id.
     * @param type $pId
     * @return User
     * @throws EntityDaoException 
     */
    public function obtenerUsuarioPorId($pId) {

        try {
            $query = "select * from user where id = [ID]";
            $query = str_replace("[ID]", $pId, $query);

            $result = $this->dataSource->executeQuery($query);

            if ($result) {
                $usuario = $this->getInstaceFromArray($result[0]);
            }
            return $usuario;
        } catch (Exception $pEx) {
            $message = "Fallo al obtener el usuario {0}.  {1}";
            throw new EntityDaoException($message);
        }
    }

    /**
     * Obtiene todos los usuarios del sistema.
     * @return User
     * @throws EntityDaoException 
     */
    public function obternerUsuariosTodos() {
        try {
            $usuarios = array();

            $query = "select * from user ";

            $result = $this->dataSource->executeQuery($query);

            if ($result) {
                foreach ($result as $fila) {
                    $usuario = $this->getInstaceFromArray($fila);
                    $usuarios[] = $usuario;
                }
            }
            return $usuarios;
        } catch (Exception $pEx) {
            $message = "Fallo al obtener la seccion {0}.  {1}";

            throw new EntityDaoException($message);
        }
    }

    /**
     * Obtiene un usuario por su nombre de usuario o nif.
     * @param type $username
     * @return User
     * @throws Exception 
     */
    public function obtenerUsuarioPorUsername($username) {
        try {
            $usuario = NULL;

            if (!is_null($username)) {
                $query = "SELECT * FROM user WHERE username = '" . $username . "' ";
                $result = $this->executeQuery($query);

                if ($result) {
                    $usuario = $this->getInstaceFromArray($result[0]);
                }
            }

            return $usuario;
        } catch (Exception $pEx) {
            throw new Exception("Fallo al obtener el usuario. " . $pEx->getMessage());
        }
    }

    public function obtenerUsuariosFiltro($pagina = 0, $filtro = null) {

        $cantSlotsPorPagina = \flowcode\mvc\kernel\Config::get('listados', 'usuarios_por_pagina');
        $desde = $pagina * $cantSlotsPorPagina;
        $data = array();

        $filterList = array();
        if (!is_null($filtro)) {
            $filterList = explode(" ", $filtro);
        }

        try {
            $query = "SELECT * FROM user n ";
            if (!is_null($filtro)) {
                $query .= " WHERE 1=2 ";
                foreach ($filterList as $filter) {
                    $query .= " OR username LIKE '%" . $filter . "%'";
                    $query .= " OR nombre LIKE '%" . $filter . "%'";
                    $query .= " OR apellido LIKE '%" . $filter . "%'";
                    $query .= " OR mail LIKE '%" . $filter . "%'";
                }
            } else {
                $query .= " WHERE 1";
            }
            $query .= " ORDER BY username ASC ";
            $query .= " LIMIT $desde , $cantSlotsPorPagina ";

            $result = $this->dataSource->executeQuery($query);
            if ($result) {
                foreach ($result as $fila) {
                    $entidad = $this->getInstaceFromArray($fila);
                    $data[] = $entidad;
                }
            }

            return $data;
        } catch (Exception $pEx) {
            throw new EntityDaoException("Fallo al obtener la noticias.  SQLError: " . $pEx->getMessage());
        }
    }

    public function obtenerTotalUsuariosFiltro($filtro = null) {
        $cantidad = -1;
        $filterList = array();
        if (!is_null($filtro)) {
            $filterList = explode(" ", $filtro);
        }
        try {
            $query = "SELECT COUNT(*) as total FROM user ";
            if (!is_null($filtro)) {
                $query .= " WHERE 1=2 ";
                foreach ($filterList as $filter) {
                    $query .= " OR username LIKE '%" . $filter . "%'";
                    $query .= " OR nombre LIKE '%" . $filter . "%'";
                    $query .= " OR apellido LIKE '%" . $filter . "%'";
                    $query .= " OR mail LIKE '%" . $filter . "%'";
                }
            } else {
                $query .= " WHERE 1";
            }
            $result = $this->dataSource->executeQuery($query);
            if ($result) {
                $cantidad = $result[0]['total'];
            }
            return $cantidad;
        } catch (Exception $pEx) {
            throw new EntityDaoException("Fallo al obtener la noticias.  SQLError: " . $pEx->getMessage());
        }
    }

    /**
     * Elimina el Usuario correspondiente al ID.
     * @param Boolean $success.
     */
    public function delete(User $user) {
        $em = EntityManager::getInstance();
        return $em->delete($user);
    }

    /**
     * Return a Collection of roles.
     * @param User $user
     * @return Collection roles.
     */
    public function findRoles(User $user) {
        $em = EntityManager::getInstance();
        return $em->findRelation($user, "Roles");
    }
    
    public function findByFilter($filter = null, $page = 1) {
        $em = EntityManager::getInstance();
        $pager = $em->findByGenericFilter("user", $filter, $page);
        return $pager;
    }

    private function getInstaceFromArray($array) {
        $usuario = null;
        if (!is_null($array)) {
            $usuario = new User();
            $usuario->setId($array["id"]);
            $usuario->setUsername($array["username"]);
            $usuario->setPassword($array["password"]);
            $usuario->setMail($array["mail"]);
            $usuario->setName($array["name"]);
        }
        return $usuario;
    }

}

?>
