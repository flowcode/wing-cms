<?php

namespace flowcode\smooth\mvc;

use flowcode\smooth\mvc\Controller;
use flowcode\smooth\mvc\IView;

/**
 * Description of View
 *
 * @author juanma
 */
class PlainView implements IView {

    protected $viewData;


    function __construct($viewData) {
        $this->viewData = $viewData;
    }

    public function render() {
        echo $this->viewData["data"];
    }

}

?>
