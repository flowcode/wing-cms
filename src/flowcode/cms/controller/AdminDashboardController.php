<?php

namespace flowcode\cms\controller;

use flowcode\cms\service\UserService;
use flowcode\wing\mvc\BareView;
use flowcode\wing\mvc\Controller;
use flowcode\wing\mvc\HttpRequest;

/**
 * 
 */
class AdminDashboardController extends Controller {

    private $userService;

    public function __construct() {
        $this->userService = new UserService();
        $this->setIsSecure(true);
        $this->addPermission("admin-login");
    }

    public function index(HttpRequest $httpRequest) {
        $viewData["message"] = "";
        return new BareView($viewData, "cms/view/admin/admin-home");
    }

}

?>
