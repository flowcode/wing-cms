<?php

namespace flowcode\cms\controller;

use flowcode\cms\service\UserService;
use flowcode\wing\mvc\Controller;
use flowcode\wing\mvc\HttpRequest;
use flowcode\wing\mvc\View;

/**
 * 
 */
class AdminHomeController extends Controller {

    private $userService;

    public function __construct() {
        $this->userService = new UserService();
        $this->setIsSecure(true);
        $this->addAllowedRole("admin");
    }

    public function index(HttpRequest $httpRequest) {
        $viewData["message"] = "";
        return View::getControllerView($this, "cms/view/admin/admin-home", $viewData);
    }

}

?>