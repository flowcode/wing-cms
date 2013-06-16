<?php

namespace flowcode\cms\controller;

use flowcode\cms\domain\Role;
use flowcode\cms\domain\User;
use flowcode\cms\service\RoleService;
use flowcode\cms\service\UserService;
use flowcode\wing\mvc\BareView;
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
        $this->addPermission('admin-login');
        $this->userService = new UserService();
    }

    function index($httpRequest) {
        $viewData['filter'] = $httpRequest->getParameter('search');
        $viewData['page'] = $httpRequest->getParameter('page');
        if (is_null($viewData['page']) || empty($viewData['page'])) {
            $viewData['page'] = 1;
        }
        $viewData['pager'] = $this->userService->findByFilter($viewData['filter'], $viewData['page']);
        return new BareView($viewData, "cms/view/admin/userList");
    }

    function create($HttpRequest) {
        $viewData['user'] = new User();

        $roleSrv = new RoleService();
        $viewData['roles'] = $roleSrv->findAll();

        return new BareView($viewData, "cms/view/admin/userForm");
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

        $viewData["response"] = "success";
        return new BareView($viewData, "cms/view/admin/form-response");
    }

    function edit($HttpRequest) {

        // en el primer parametro tiene que venir el id
        $params = $HttpRequest->getParams();
        $id = $params[0];

        $viewData['user'] = $this->userService->obtenerUsuarioPorId($id);

        $roleSrv = new RoleService();
        $viewData['roles'] = $roleSrv->findAll();

        return new BareView($viewData, "cms/view/admin/userForm");
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

        $viewData["response"] = "success";
        return new BareView($viewData, "cms/view/admin/form-response");
    }

    function delete($HttpRequest) {
        // en el primer parametro tiene que venir el id
        $params = $HttpRequest->getParams();
        $id = $params[0];

        $this->userService->eliminarUsuarioPorId($id);

        $viewData["response"] = "success";
        return new BareView($viewData, "cms/view/admin/form-response");
    }

}

?>
