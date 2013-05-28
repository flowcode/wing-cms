<?php

namespace flowcode\cms\controller;

use flowcode\cms\service\UserService;
use flowcode\wing\mvc\BareView;
use flowcode\wing\mvc\Controller;
use flowcode\wing\mvc\HttpRequest;
use flowcode\wing\mvc\View;

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
            $this->redirect("/admin");
            return true;
        }

        $viewData["message"] = "Invalid username and password combination";

        return View::getViewWithSpecificMaster($this, "cms/view/login/index", $viewData, "cms/view/master-login");
    }

    public function logout(HttpRequest $httpRequest) {
        // destroy session
        session_destroy();
        $this->redirect("/adminLogin/index");
    }

    public function restricted(HttpRequest $httpRequest) {
        $viewData["message"] = "";
        $viewData["data"] = "";
        return new BareView($viewData, "cms/view/admin/restricted");
    }

}

?>
