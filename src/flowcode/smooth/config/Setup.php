<?php

namespace flowcode\smooth\config;

use flowcode\smooth\mvc\SmoothSetup;

/**
 * Description of Setup
 *
 * @author juanma
 */
class Setup extends SmoothSetup {

    function __construct() {
        parent::__construct();

        /* controllers */
        $this->scanneableControllers["front"] = "\\flowcode\\front\\controller\\";
        $this->scanneableControllers["cms"] = "\\flowcode\\cms\\controller\\";
        $this->scanneableControllers["demo"] = "\\flowcode\\demo\\controller\\";
        $this->scanneableControllers["blog"] = "\\flowcode\\blog\\controller\\";
        $this->scanneableControllers["smooth"] = "\\flowcode\\smooth\\controller\\";

        /* dirs */
        $this->dirs['public'] = "/public";

        /* default controller */
        //$this->defaultController = "\\flowcode\\smooth\\controller\\DefaultController";
        //$this->defaultMethod = "hello";

        /* cms module manager */
        $this->defaultController = "\\flowcode\\cms\\controller\\PageController";
        $this->defaultMethod = "manage";

        /* cms login manager */
        $this->loginController = "\\flowcode\\cms\\controller\\AdminLoginController";
        $this->loginMethod = "index";
        $this->restrictedMethod = "restricted";
    }

}

?>
