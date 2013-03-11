<?php

namespace flowcode\smooth\mvc;

/**
 * Description of SmoothSetup}
 *
 * @author juanma
 */
class SmoothSetup {

    protected $scanneableControllers;
    protected $dirs;
    
    protected $defaultController;
    protected $defaultMethod;
    
    protected $loginController;
    protected $loginMethod;
    protected $restrictedMethod;

    function __construct() {
        $this->scanneableControllers = array();
        $this->dirs = array();
        $this->defaultController = array();
        $this->defaultMethod = array();
    }

    public function getScanneableControllers() {
        return $this->scanneableControllers;
    }

    public function setScanneableControllers($scanneableControllers) {
        $this->scanneableControllers = $scanneableControllers;
    }

    public function getDefaultController() {
        return $this->defaultController;
    }

    public function getDefaultMethod() {
        return $this->defaultMethod;
    }
    
    public function getDirs() {
        return $this->dirs;
    }

    public function setDirs($dirs) {
        $this->dirs = $dirs;
    }

    public function getLoginController() {
        return $this->loginController;
    }

    public function setLoginController($loginController) {
        $this->loginController = $loginController;
    }

    public function getLoginMethod() {
        return $this->loginMethod;
    }

    public function setLoginMethod($loginMethod) {
        $this->loginMethod = $loginMethod;
    }

    public function getRestrictedMethod() {
        return $this->restrictedMethod;
    }

    public function setRestrictedMethod($restrictedMethod) {
        $this->restrictedMethod = $restrictedMethod;
    }



}

?>
