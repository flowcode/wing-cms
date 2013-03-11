<?php

namespace flowcode\blog\service;

use flowcode\blog\dao\TagDao;
use flowcode\blog\domain\Tag;

/**
 * Description of TagService
 *
 * @author juanma
 */
class TagService {
    private $tagDao;
    
    public function __construct() {
        $this->tagDao = new TagDao();
    }
    
    public function findAll(){
        return $this->tagDao->findAll();
    }
    
    public function save(Tag $tag){
        $this->tagDao->save($tag);
    }
    
    public function delete(Tag $tag){
        $this->tagDao->delete($tag);
    }
    
    
    public function findById($id){
        return $this->tagDao->findById($id);
    }
    
    
}

?>
