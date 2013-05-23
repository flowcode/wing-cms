<?php

namespace flowcode\cms\controller;

use flowcode\cms\domain\Role;
use flowcode\cms\domain\User;
use flowcode\cms\service\RoleService;
use flowcode\cms\service\UserService;
use flowcode\wing\mvc\Controller;
use flowcode\wing\mvc\View;

/**
 * Description of AdminNoticia
 *
 * @author juanma
 */
class AdminUserController extends Controller {

    private $userService;

    function __construct() {
        $this->setIsSecure(TRUE);
        $this->addAllowedRole('admin');
        $this->userService = new UserService();
    }

    function index($HttpRequest) {

        $viewData['users'] = $this->userService->obtenerUsuariosTodos();

        return View::getUnmasteredView("cms/view/admin/userList", $viewData);
    }

    function create($HttpRequest) {
        $viewData['user'] = new User();

        $roleSrv = new RoleService();
        $viewData['roles'] = $roleSrv->findAll();

        return View::getUnmasteredView("cms/view/admin/userForm", $viewData);
    }

    function save($HttpRequest) {

        // obtengo los datos
        $id = (isset($_POST['id'])) ? $_POST['id'] : NULL;
        $nombre = $_POST['name'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        $mail = $_POST['mail'];

        $roles = array();
        if (isset($_POST['roles'])) {
            foreach ($_POST['roles'] as $idRole) {
                $role = new Role();
                $role->setId($idRole);
                $roles[] = $role;
            }
        }


        // creo la nueva instancia y seteo valores
        $usuario = new User();
        $usuario->setId($id);
        $usuario->setUsername($username);
        $usuario->setPassword($password);
        $usuario->setMail($mail);
        $usuario->setName($nombre);

        $usuario->setRoles($roles);

        // la guardo
        $id = $this->userService->save($usuario);

        $viewData['users'] = $this->userService->obtenerUsuariosTodos();
        return View::getUnmasteredView("cms/view/admin/userList", $viewData);
    }

    function edit($HttpRequest) {

        // en el primer parametro tiene que venir el id
        $params = $HttpRequest->getParams();
        $id = $params[0];

        $viewData['user'] = $this->userService->obtenerUsuarioPorId($id);

        $roleSrv = new RoleService();
        $viewData['roles'] = $roleSrv->findAll();

        return View::getUnmasteredView("cms/view/admin/userForm", $viewData);
    }

    function saveEdit($HttpRequest) {

        // obtengo los datos
        $id = (isset($_POST['id'])) ? $_POST['id'] : NULL;

        // creo la nueva instancia y seteo valores
        $usuario = new User();

        $usuario->setId($id);
        $usuario->setUsername($_POST['username']);
        $usuario->setMail($_POST['mail']);
        $usuario->setName($_POST['name']);
        $usuario->setPassword($_POST["password"]);

        $roles = array();
        if (isset($_POST['roles'])) {
            foreach ($_POST['roles'] as $idRole) {
                $role = new Role();
                $role->setId($idRole);
                $roles[] = $role;
            }
        }
        $usuario->setRoles($roles);

        $passChange = TRUE;
        if (empty($_POST["password"])) {
            $user = $this->userService->obtenerUsuarioPorId($id);
            $passChange = FALSE;
            $usuario->setPassword($user->getPassword());
        }

        // la guardo
        $id = $this->userService->modificarUsuario($usuario, $passChange);

        $viewData['users'] = $this->userService->obtenerUsuariosTodos();
        return View::getUnmasteredView("cms/view/admin/userList", $viewData);
    }

    function delete($HttpRequest) {
        // en el primer parametro tiene que venir el id
        $params = $HttpRequest->getParams();
        $id = $params[0];

        $this->userService->eliminarUsuarioPorId($id);

        $viewData['users'] = $this->userService->obtenerUsuariosTodos();
        return View::getUnmasteredView("cms/view/admin/userList", $viewData);
    }

}

?>
