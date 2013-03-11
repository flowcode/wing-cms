<?php

namespace flowcode\cms\domain;

use flowcode\smooth\mvc\Entity;

/**
 * Usuario de la aplicacion.
 *
 * @author Juan Manuel Aguero.
 */
class User extends Entity {

    private $name;
    private $username;
    private $password;
    private $role;
    private $mail;

    public function __construct() {
        parent::__construct();

        // por default tiene el rol mas generico.
        $this->role = "user";
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        if (!is_null($username) && is_string($username)) {
            $this->username = $username;
        }
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        if (!is_null($password) && is_string($password)) {
            $this->password = $password;
        }
    }

    public function getRole() {
        return $this->role;
    }

    public function setRole($role) {
        if (!is_null($role) && is_string($role)) {
            $this->role = $role;
        }
    }

    public function setMail($mail) {
        $this->mail = $mail;
    }

    public function getMail() {
        return $this->mail;
    }

    public static function getInstanceFromArray($array) {
        $instance = new User();
        if (isset($array['id']))
            $instance->setId($array['id']);
        if (isset($array['username']))
            $instance->setUsername($array["username"]);
        if (isset($array['password']))
            $instance->setPassword($array["password"]);
        if (isset($array['role']))
            $instance->setRole($array["role"]);
        if (isset($array['mail']))
            $instance->setMail($array["mail"]);
        if (isset($array['nombre']))
            $instance->setNombre($array["nombre"]);
        if (isset($array['apellido']))
            $instance->setApellido($array["apellido"]);
        if (isset($array['sexo']))
            $instance->setSexo($array["sexo"]);
        return $instance;
    }

}

?>
