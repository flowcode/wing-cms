<?php

/**
 * Description of UnitOfWork
 *
 * @author juanma
 */
class UnitOfWork {

    private $jobs = null;

    function __construct() {
        
    }

    public function add(Query $query) {
        $this->jobs[] = $query;
    }

    public function commit() {
        
    }
    
    public function rollback() {
        
    }

}

?>
