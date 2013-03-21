<?php

/**
 * Description of Query
 *
 * @author JMA <jaguero@flowcode.com.ar>
 */
class Query {

    private $queryString;

    function __construct($queryString) {
        $this->queryString = $queryString;
    }

    public function __toString() {
        return $this->queryString;
    }

}

?>
