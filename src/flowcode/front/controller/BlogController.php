<?php

namespace flowcode\front\controller;

use flowcode\blog\service\PostService;
use flowcode\cms\domain\Page;
use flowcode\cms\service\PageService;
use flowcode\wing\mvc\Controller;
use flowcode\wing\mvc\HttpRequest;
use flowcode\wing\mvc\View;

/**
 * Description of HomeController
 *
 * @author juanma
 */
class BlogController extends Controller {

    public function __construct() {
        $this->setIsSecure(FALSE);
    }

    public function post(HttpRequest $httpRequest) {

        $p = explode("/", $httpRequest->getRequestedUrl());
        $permalink = $p[3];

        $postSrv = new PostService();
        $post = $postSrv->findByPermalink($permalink);

        $page = new Page();
        $page->setName($post->getTitle());
        if (strlen($post->getDescription()) > 0) {
            $page->setDescription($post->getDescription());
        }

        $viewData['page'] = $page;
        $viewData['post'] = $post;

        return View::getControllerView($this, "front/view/blog/post", $viewData);
    }

    public function index(HttpRequest $httpRequest) {

        $pageSrv = new PageService();
        $viewData['page'] = $pageSrv->getPageByPermalink("blog");

        $viewData['tag'] = $httpRequest->getParameter('tag');

        $viewData['pageNumber'] = $httpRequest->getParameter('page');
        if (is_null($viewData['pageNumber']) || empty($viewData['pageNumber'])) {
            $viewData['pageNumber'] = 1;
        }

        $postSrv = new PostService();
        $viewData['pager'] = $postSrv->findByTag($viewData['tag'], $httpRequest->getParameter('year'), $httpRequest->getParameter('month'), $viewData['pageNumber']);

        return View::getControllerView($this, "front/view/blog/index", $viewData);
    }

}

?>
