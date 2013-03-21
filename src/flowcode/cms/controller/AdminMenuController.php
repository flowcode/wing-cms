<?php

namespace flowcode\cms\controller;

use flowcode\cms\domain\ItemMenu;
use flowcode\cms\domain\Menu;
use flowcode\cms\service\ItemMenuService;
use flowcode\cms\service\MenuService;
use flowcode\cms\service\PageService;
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
        $this->addAllowedRole('admin');
        $this->menuService = new MenuService();
    }

    function index($HttpRequest) {
        $viewData['menus'] = $this->menuService->findAll();

        return View::getControllerView($this, "cms/view/admin/menuList", $viewData);
    }

    function ver($HttpRequest) {
        // en el primer parametro tiene que venir el id
        $params = $HttpRequest->getParams();
        $id = $params[0];
        $menu = $this->menuService->obtenerMenuPorId($id);
        require_once "view/admin/menu/menu.view.php";
    }

    function create($HttpRequest) {
        $viewData['menu'] = new Menu();

        return View::getControllerView($this, "cms/view/admin/menuCreate", $viewData);
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

        $pageSrv = new PageService();
        $pages = $pageSrv->findAll();

        $itemMenuSrv = new ItemMenuService();
        $items = $itemMenuSrv->findByMenu($menu);

        $viewData['menu'] = $menu;
        $viewData['items'] = $items;
        $viewData['pages'] = $pages;


        return View::getControllerView($this, "cms/view/admin/menuEdit", $viewData);
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
        $itemmenu->setName($httpRequest->getParameter("name"));
        $itemmenu->setFatherId($httpRequest->getParameter("fatherId"));
        $itemmenu->setPageId($httpRequest->getParameter("pageId"));
        $itemmenu->setMenuId($httpRequest->getParameter("menuId"));
        $itemmenu->setLinkUrl($httpRequest->getParameter("linkurl"));
        $itemmenu->setOrder($httpRequest->getParameter("order"));

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
        return View::getPlainView($this, $viewName, $viewData);
    }

}

?>
