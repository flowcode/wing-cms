<?php

namespace flowcode\front\controller;

use flowcode\blog\service\PostService;
use flowcode\smooth\mvc\Controller;
use flowcode\smooth\mvc\HttpRequest;
use flowcode\smooth\mvc\View;

/**
 * Description of HomeController
 *
 * @author juanma
 */
class HomeController extends Controller {

    public function __construct() {
        $this->setIsSecure(FALSE);
    }

    public function index(HttpRequest $httpRequest) {

        $pageSrv = new \flowcode\cms\service\PageService();
        $viewData['page'] = $pageSrv->getPageByPermalink("home");

        $viewData['tag'] = $httpRequest->getParameter('tag');

        $viewData['pageNumber'] = $httpRequest->getParameter('page');
        if (is_null($viewData['pageNumber']) || empty($viewData['pageNumber'])) {
            $viewData['pageNumber'] = 1;
        }

        $postSrv = new PostService();
        $viewData['pager'] = $postSrv->findByTag($viewData['tag'], $httpRequest->getParameter('year'), $httpRequest->getParameter('month'), $viewData['pageNumber']);

        return View::getControllerView($this, "front/view/page/home", $viewData);
    }

}

?>
