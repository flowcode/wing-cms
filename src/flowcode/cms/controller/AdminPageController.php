<?php

namespace flowcode\cms\controller;

use flowcode\cms\domain\Page;
use flowcode\cms\service\PageService;
use flowcode\wing\mvc\Controller;
use flowcode\wing\mvc\HttpRequest;
use flowcode\wing\mvc\View;
use flowcode\wing\utils\PermalinkBuilder;

/**
 * Description of AdminPageController
 *
 * @author juanma
 */
class AdminPageController extends Controller {

    private $pageSrv;

    function __construct() {
        $this->pageSrv = new PageService();
        $this->addPermission("admin-page-create");
        $this->addPermission("admin-page-delete");
        $this->addPermission("admin-page-update");
        $this->setIsSecure(true);
    }

    public function pages(HttpRequest $httpRequest) {

        $viewData['filter'] = $httpRequest->getParameter('search');

        $viewData['page'] = $httpRequest->getParameter('page');
        if (is_null($viewData['page']) || empty($viewData['page'])) {
            $viewData['page'] = 1;
        }

        $viewData['pager'] = $this->pageSrv->findByFilter($viewData['filter'], $viewData['page']);

        return View::getControllerView($this, "cms/view/admin/pages", $viewData);
    }

    public function create(HttpRequest $httpRequest) {
        $viewData['page'] = new Page();
        return View::getControllerView($this, "cms/view/admin/pageForm", $viewData);
    }

    public function save(HttpRequest $httpRequest) {

        // obtengo los datos
        $id = (isset($_POST['id']) && !empty($_POST['id'])) ? $_POST['id'] : NULL;
        $name = $httpRequest->getParameter("name");
        $permalink = (isset($_POST['permalink']) && !empty($_POST['permalink'])) ? $_POST['permalink'] : $this->buildPermalink($name);

        $page = new Page();
        $page->setId($id);
        $page->setName($name);
        $page->setPermalink($permalink);
        $page->setDescription($httpRequest->getParameter("description"));
        $page->setHtmlContent($httpRequest->getParameter("htmlContent"));
        $page->setStatus($httpRequest->getParameter("status"));
        $page->setType($httpRequest->getParameter("type"));

        // la guardo
        $idsec = $this->pageSrv->savePage($page);

        $this->redirect("/adminPage/pages");
    }

    public function edit(HttpRequest $httpRequest) {
        $idPage = $httpRequest->getParameter("id");

        $pageSrv = new PageService();
        $page = $pageSrv->findPageById($idPage);

        $viewData['page'] = $page;
        return View::getControllerView($this, "cms/view/admin/pageForm", $viewData);
    }

    public function delete(HttpRequest $httpRequest) {
        $idPage = $httpRequest->getParameter("id");
        $idLocal = $httpRequest->getParameter("local");

        $pageSrv = new PageService();
        $pageSrv->eliminarPagePorId($idPage);

        $to_url = "/adminLocal/pagees/$idLocal";
        $this->redirect($to_url);
    }

    private function buildPermalink($title) {

        $permalinkBuilder = new PermalinkBuilder();
        $permalinkBuilder->setInputString($title);
        $permalinkBuilder->build();
        $permalink = $permalinkBuilder->getPermalink();

        $pages = $this->pageSrv->getPagesByPermalinkAprox($permalink);
        $permalinkBuilder->setSimilarCount(count($pages));
        $permalinkBuilder->build();
        $permalink = $permalinkBuilder->getPermalink();
        return $permalink;
    }

}

?>
