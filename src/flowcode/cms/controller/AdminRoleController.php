<?php

namespace flowcode\cms\controller;

use flowcode\cms\domain\Permission;
use flowcode\cms\domain\Role;
use flowcode\cms\service\PermissionService;
use flowcode\cms\service\RoleService;
use flowcode\wing\mvc\Controller;
use flowcode\wing\mvc\HttpRequest;
use flowcode\wing\mvc\View;

/**
 * Description of AdminNoticia
 *
 * @author juanma
 */
class AdminRoleController extends Controller {

    private $roleService;

    function __construct() {
        $this->setIsSecure(TRUE);
        $this->addAllowedRole('admin');
        $this->roleService = new RoleService();
    }

    function index(HttpRequest $HttpRequest) {

        $viewData['roles'] = $this->roleService->findAll();

        return View::getControllerView($this, "cms/view/admin/roleList", $viewData);
    }

    function create(HttpRequest $HttpRequest) {
        $viewData['role'] = new Role();
        
        $permissionSrv = new PermissionService();
        $viewData['permissions'] = $permissionSrv->findAll();

        return View::getControllerView($this, "cms/view/admin/roleForm", $viewData);
    }

    function save(HttpRequest $httpRequest) {

        $id = (isset($_POST['id']) && !empty($_POST["id"]) ) ? $_POST['id'] : NULL;
        $nombre = $httpRequest->getParameter("name");

        $role = new Role();
        $role->setId($id);
        $role->setName($nombre);

        $permissions = array();
        if (isset($_POST['permissions'])) {
            foreach ($_POST['permissions'] as $idPermission) {
                $permission = new Permission();
                $permission->setId($idPermission);
                $permissions[] = $permission;
            }
        }
        $role->setPermissions($permissions);

        $id = $this->roleService->save($role);

        $this->redirect("/adminRole/index");
    }

    function edit(HttpRequest $HttpRequest) {

        // en el primer parametro tiene que venir el id
        $params = $HttpRequest->getParams();
        $id = $params[0];

        $viewData['role'] = $this->roleService->findById($id);
        
        $permissionSrv = new PermissionService();
        $viewData['permissions'] = $permissionSrv->findAll();

        return View::getControllerView($this, "cms/view/admin/roleForm", $viewData);
    }

    function delete($HttpRequest) {
        // en el primer parametro tiene que venir el id
        $params = $HttpRequest->getParams();
        $id = $params[0];

        $role = $this->roleService->findById($id);
        $this->roleService->delete($role);

        $this->redirect("/adminRole/index");
    }

}

?>
