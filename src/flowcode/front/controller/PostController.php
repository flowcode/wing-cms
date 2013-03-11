<?php

namespace flowcode\front\controller;

use flowcode\blog\service\PostService;
use flowcode\cms\domain\Page;
use flowcode\wing\mvc\Controller;
use flowcode\wing\mvc\HttpRequest;
use flowcode\wing\mvc\View;

/**
 * Description of HomeController
 *
 * @author juanma
 */
class PostController extends Controller {

    public function __construct() {
        $this->setIsSecure(FALSE);
    }

    public function post(HttpRequest $httpRequest) {

        $p = explode("/", $httpRequest->getRequestedUrl());
        $permalink = $p[2];
        
        $postSrv = new PostService();
        $post = $postSrv->findByPermalink($permalink);

        $page = new Page();
        $page->setName($post->getTitle());
        $page->setDescription($post->getIntro());

        $viewData['page'] = $page;
        $viewData['post'] = $post;

        return View::getControllerView($this, "front/view/post/post", $viewData);
    }

}

?>
