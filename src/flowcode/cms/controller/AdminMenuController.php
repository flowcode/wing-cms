<?php

namespace flowcode\cms\controller;

use flowcode\cms\domain\ItemMenu;
use flowcode\cms\domain\Menu;
use flowcode\cms\service\ItemMenuService;
use flowcode\cms\service\MenuService;
use flowcode\cms\service\PageService;
use flowcode\wing\mvc\BareView;
use flowcode\wing\mvc\Controller;
use flowcode\wing\mvc\HttpRequest;
use flowcode\wing\mvc\PlainView;
use flowcode\wing\mvc\View;

/**
 * Description of AdminMenu
 *
 * @author Juan Manuel Aguero.
 */
class AdminMenuController extends Controller {

    private $menuService;

    function __construct() {
        $this->setIsSecure(TRUE);
        $this->addPermission("admin-menu-create");
        $this->addPermission("admin-menu-edit");
        $this->addPermission("admin-menu-delete");
        $this->menuService = new MenuService();
    }

    function index($HttpRequest) {
        $viewData['menus'] = $this->menuService->findAll();
        return new BareView($viewData, "cms/view/admin/menuList");
    }

    function create($HttpRequest) {
        $viewData['menu'] = new Menu();
        return new BareView($viewData, "cms/view/admin/menuCreate");
    }

    function save(HttpRequest $httpRequest) {

        // obtengo los datos
        $id = null;
        if (isset($_POST['id']) && !empty($_POST['id'])) {
            $id = $_POST['id'];
        }

        // creo la nueva instancia y seteo valores
        $menu = new Menu();
        $menu->setId($id);
        $menu->setName($httpRequest->getParameter("name"));

        // la guardo
        $id = $this->menuService->save($menu);

        $this->redirect("/adminMenu/index");
    }

    function edit($HttpRequest) {

        // en el primer parametro tiene que venir el id
        $params = $HttpRequest->getParams();
        $id = $params[0];

        $menu = $this->menuService->findById($id);

        $itemMenuSrv = new ItemMenuService();
        $items = $itemMenuSrv->findFathersByMenu($menu);

        $viewData['menu'] = $menu;
        $viewData['items'] = $items;

        return new BareView($viewData, "cms/view/admin/menuEdit");
    }

    function eliminarAction($HttpRequest) {
        // en el primer parametro tiene que venir el id
        $params = $HttpRequest->getParams();
        $id = $params[0];

        $this->menuService->eliminarMenuPorId($id);

        $this->redirect("/adminMenu/index");
    }

    public function saveItemMenu(HttpRequest $httpRequest) {

        $itemMenuSrv = new ItemMenuService();
        $itemmenu = new ItemMenu();
        $id = $httpRequest->getParameter("id");
        if ($id != null && !empty($id)) {
            $itemmenu->setId($httpRequest->getParameter("id"));
        }
        $itemmenu->setName($httpRequest->getParameter("name"));
        $itemmenu->setMenuId($httpRequest->getParameter("menuId"));
        $itemmenu->setFatherId($httpRequest->getParameter("fatherId"));
        $itemmenu->setLinkUrl($httpRequest->getParameter("linkurl"));
        $id = $itemMenuSrv->save($itemmenu);

        $viewData['data'] = $id;
        return new PlainView($viewData);
    }

    public function deleteItemMenu($httpRequest) {
        $id = $httpRequest->getParameter("id");

        $itemMenuSrv = new ItemMenuService();
        $itemMenuSrv->deleteById($id);

        $viewData['data'] = $id;
        return new PlainView($viewData);
    }

    public function saveItemsOrder(HttpRequest $httpRequest) {

        $items = $httpRequest->getParameter("items");
        foreach ($items as $item) {
            $itemMenuSrv = new ItemMenuService();
            $itemMenu = $itemMenuSrv->findById($item["id"]);
            $itemMenu->setOrder($item["orden"]);
            $itemMenuSrv->save($itemMenu);
            $viewData['data'] = "ok";
        }
        return View::getPlainView($this, "wing/view/default", $viewData);
    }

}

?>
