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
     * Enviar un mail de confirmacion al mail del usuario.
     * @param type $usuario 
     */
    public function enviarMailConfirmacion($usuario) {
        $nombre = $usuario->getNombre();
        $userMail = $usuario->getMail();
        $username = $usuario->getUsername();

        $subject = 'Interpeñas - Confirmar direccion de e-mail';

        $url = Config::get("global", "url");
        $imgUri = $url . Config::get("images", "logo");

        $message = "<img src='" . $imgUri . "'/>";
        $message .= "<p>Gracias " . $nombre . " por registrate. Para completar tu alta, por favor, haz click en el siguiente enlace.</p>";
        $message .= "<p><a href='" . $url . "/usuario/confirmar/user/" . $username . "/mail/" . $userMail . "'>Confirmar e-mail</a></p>";

        $headers = "MIME-Version: 1.0\r\n"
                . "Content-Type: text/html; charset=utf-8\r\n"
                . "Content-Transfer-Encoding: 8bit\r\n"
                . "From: =?UTF-8?B?" . base64_encode("Interpeñas") . "?= <web@interp.es>\r\n"
                . "X-Mailer: PHP/" . phpversion();
        mail($userMail, $subject, $message, $headers);
    }

    /**
     * Authentica un usuario en la sesion.
     * @param type $user 
     */
    public function authenticateUser($user) {
        if ($user->getUsername() != "") {
            $_SESSION['user']['username'] = $user->getUsername();
        }
        $_SESSION['user']['role'] = $user->getRole();
    }

    /**
     * Confirma el mail de un usuario.
     * @param type $username
     * @param type $mail
     * @return boolean 
     */
    public function confirmarUsuario($username, $mail) {
        $respuesta = false;
        $usuario = $this->userDao->obtenerUsuarioPorUsername($username);

        if ($usuario != null && $usuario->getMail() == $mail) {
            $usuario->setConfirmed(1);
            $this->save($usuario);
            $respuesta = true;
        }

        return $respuesta;
    }

    public function getUserDao() {
        return $this->userDao;
    }

    public function setUserDao($userDao) {
        $this->userDao = $userDao;
    }

    public function realizarContacto($contacto) {

        $to = "web@interp.es";
        $nombre = $contacto["nombre"];
        $userMail = $contacto["mail"];

        $subject = "Interpeñas -Contacto: " . $contacto["asunto"];

        $url = Config::get("global", "url");
        $imgUri = $url . Config::get("images", "logo");

        $message = "<img src='" . $imgUri . "'/>";
        $message .= "<br/>";
        $message .= $contacto["cuerpo"];

        $headers = "MIME-Version: 1.0\r\n"
                . "Content-Type: text/html; charset=utf-8\r\n"
                . "Content-Transfer-Encoding: 8bit\r\n"
                . "From: =?UTF-8?B?" . base64_encode($nombre) . "?= <$userMail>\r\n"
                . "X-Mailer: PHP/" . phpversion();
        mail($to, $subject, $message, $headers);

        if (isset($contacto["recibir_copia"])) {
            mail($userMail, $subject, $message, $headers);
        }

        return TRUE;
    }

}

?>
