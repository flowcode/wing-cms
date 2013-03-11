<?php

namespace flowcode\cms\controller;

use flowcode\cms\service\UserService;
use flowcode\smooth\mvc\Controller;
use flowcode\smooth\mvc\HttpRequest;
use flowcode\smooth\mvc\View;

/**
 * 
 */
class AdminLoginController extends Controller {

    private $userService;

    public function __construct() {
        $this->userService = new UserService();
        $this->setIsSecure(false);
    }

    public function index(HttpRequest $httpRequest) {
        $viewData["message"] = "";
        $viewData = null;
        return View::getViewWithSpecificMaster($this, "cms/view/login/index", $viewData, "cms/view/master-login");
    }

    public function validate(HttpRequest $httpRequest) {

        $username = $_POST['username'];
        $password = $_POST['password'];

        if ($this->userService->loginUsuario($username, $password)) {
            $this->redirect("/admin/index");
            return true;
        }

        $viewData["message"] = "Invalid username and password combination.";

        return View::getViewWithSpecificMaster($viewData, "login/index", $this, "master-login");
    }

    public function logout(HttpRequest $httpRequest) {
        // destroy session
        session_destroy();
        $this->redirect("/adminLogin/index");
    }

}

?>
