<?php

namespace flowcode\cms\controller;

use flowcode\cms\domain\Permission;
use flowcode\cms\service\PermissionService;
use flowcode\wing\mvc\Controller;
use flowcode\wing\mvc\HttpRequest;
use flowcode\wing\mvc\View;

/**
 * Description of AdminNoticia
 *
 * @author juanma
 */
class AdminPermissionController extends Controller {

    private $permissionService;

    function __construct() {
        $this->setIsSecure(TRUE);
        $this->addAllowedRole('admin');
        $this->permissionService = new PermissionService();
    }

    function index(HttpRequest $HttpRequest) {
        $viewData['permissions'] = $this->permissionService->findAll();
        return View::getUnmasteredView("cms/view/admin/permissionList", $viewData);
    }

    function create(HttpRequest $HttpRequest) {
        $viewData['permission'] = new Permission();
        return View::getUnmasteredView("cms/view/admin/permissionForm", $viewData);
    }

    function save(HttpRequest $httpRequest) {

        // obtengo los datos
        $id = (isset($_POST['id']) && !empty($_POST["id"]) ) ? $_POST['id'] : NULL;
        $nombre = $httpRequest->getParameter("name");

        // creo la nueva instancia y seteo valores
        $permission = new Permission();
        $permission->setId($id);
        $permission->setName($nombre);

        // la guardo
        $id = $this->permissionService->save($permission);

        $viewData['permissions'] = $this->permissionService->findAll();
        return View::getUnmasteredView("cms/view/admin/permissionList", $viewData);
    }

    function edit(HttpRequest $HttpRequest) {

        // en el primer parametro tiene que venir el id
        $params = $HttpRequest->getParams();
        $id = $params[0];

        $viewData['permission'] = $this->permissionService->findById($id);

        //return View::getControllerView($this, "cms/view/admin/permissionForm", $viewData);
        return View::getUnmasteredView("cms/view/admin/permissionForm", $viewData);
    }

    function delete($HttpRequest) {
        // en el primer parametro tiene que venir el id
        $params = $HttpRequest->getParams();
        $id = $params[0];

        $permission = $this->permissionService->findById($id);
        $this->permissionService->delete($permission);

        $viewData['permissions'] = $this->permissionService->findAll();
        return View::getUnmasteredView("cms/view/admin/permissionList", $viewData);
    }

}

?>
