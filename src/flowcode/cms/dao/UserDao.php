<?php

namespace flowcode\cms\dao;

use Exception;
use flowcode\cms\domain\User;
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
        try {
            $id = $usuario->getId();
            $password = $usuario->getPassword();
            $username = $usuario->getUsername();
            $role = $usuario->getRole();
            $mail = $usuario->getMail();
            $nombre = $usuario->getNombre();
            $apellido = $usuario->getApellido();

            // si estoy editando el usuario
            if ($id && $id != null && $id > -1) {
                $query = "UPDATE user ";
                $query .= "SET username='$username',";
                $query .= "password='$password',";
                $query .= "nombre='$nombre',";
                $query .= "apellido='$apellido',";
                $query .= "role='$role',";
                $query .= "mail='$mail' ";
                $query .= "Where id=$id ";
                $this->dataSource->executeNonQuery($query);
            } else {
                $query = "INSERT INTO user (username, password, role, mail, nombre, apellido)";
                $query .= "VALUES ('$username', '$password', '$role', '$mail', '$nombre', '$apellido' )";
                $newId = $this->dataSource->insertSQL($query);
                $id = $newId;
            }
            return $id;
        } catch (Exception $pEx) {
            throw new Exception("Fallo al obtener el usuario. " . $pEx->getMessage());
        }
    }

    public function getUserByUsernamePassword($username, $password) {
        $user = null;
        $em = EntityManager::getInstance();
        $filter = "username = '" . $username . "' AND password = '" . $password . "'";
        $users = $em->findByWhereFilter("user", $filter);

        if (count($users) > 0) {
            $user = $users[0];
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
     * @param type $id 
     */
    function eliminarUsuarioPorId($id) {

        $query = "DELETE FROM user ";
        $query .= "WHERE id = $id";

        $this->dataSource->executeNonQuery($query);
    }

    private function getInstaceFromArray($array) {
        $usuario = null;
        if (!is_null($array)) {
            $usuario = new User();
            $usuario->setId($array["id"]);
            $usuario->setUsername($array["username"]);
            $usuario->setPassword($array["password"]);
            $usuario->setRole($array["role"]);
            $usuario->setMail($array["mail"]);
            $usuario->setNombre($array["nombre"]);
            $usuario->setApellido($array["apellido"]);
        }
        return $usuario;
    }

}

?>
