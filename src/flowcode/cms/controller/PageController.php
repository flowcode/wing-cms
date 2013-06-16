<?php

namespace flowcode\cms\controller;

use flowcode\cms\domain\Page;
use flowcode\cms\domain\PlainPageManager;
use flowcode\cms\service\PageService;
use flowcode\wing\mvc\Controller;
use flowcode\wing\mvc\HttpRequest;
use flowcode\wing\mvc\Router;
use flowcode\wing\mvc\View;

/**
 * 
 */
class PageController extends Controller {

    private $pageService;

    function __construct() {
        $this->setIsSecure(false);
        $this->pageService = new PageService();
        $this->setName("page");
        $this->setModule("cms");
    }

    public static function getPageByPermalink($permalink) {
        $page = $this->pageService->getPageByPermalink($permalink);
        return $page;
    }

    public function manage(HttpRequest $httpRequest) {
        $permalink = substr($httpRequest->getRequestedUrl(), 1);

        $page = null;
        if (strlen($permalink) <= 0) {
            $permalink = Router::get("homepage", "permalink");
        }
        $page = $this->pageService->getPageByPermalink($permalink);

        if (is_null($page)) {
            return $this->manageNotFound($permalink);
        }

        switch ($page->getType()) {
            case Page::$type_plain:
                return $this->managePlainPage($page);
                break;
            case Page::$type_custom:
                $this->manageCustomPage($page);
                break;
            default:
                $this->manageNotFound($permalink);
                break;
        }
    }

    private function managePlainPage(Page $page) {
        $pm = new PlainPageManager($page);
        $viewData = $pm->getViewData();

        return View::getControllerView($this, "cms/view/page/plain-page", $viewData);
    }

    private function manageCustomPage(Page $page) {
        die("not implemented");
        require_once "view/page/pageList.view.php";
    }

    private function manageNotFound($permalink) {
        $viewData['page'] = new Page();
        $viewData['msg'] = "";
        return View::getControllerView($this, "front/view/page/page-not-found", $viewData);
    }

    public function error() {
        $viewData['data'] = "";
        return View::getViewWithSpecificMaster($this, "cms/view/page/error-page", $viewData, "cms/view/master-static");
    }

}

?>
