<?php

namespace flowcode\cms\service;

use flowcode\cms\dao\PageDao;
use flowcode\cms\domain\Page;
use flowcode\wing\mvc\Config;
use flowcode\wing\utils\Pager;

/**
 * 
 */
class PageService {

    private $pageDao;

    function __construct() {
        $this->pageDao = new PageDao();
    }

    /**
     * Funcion que guarda una Page.
     * @param type $titulo
     * @param type $descipcion
     * @return type 
     */
    public function savePage($page) {
        $id = $this->pageDao->save($page);
        return $id;
    }

    /**
     * Get all pages.
     * @return array $pages.
     */
    public function findAll() {
        $pages = $this->pageDao->findAll();
        return $pages;
    }

    /**
     * Return a pager.
     * @param type $filter
     * @param type $page
     * @return Pager $pager.
     */
    public function findByFilter($filter = null, $page = 1) {
        $pager = $this->pageDao->findByFilter($filter, $page);
        return $pager;
    }

    /**
     * Obtiene todas las Pages activas en orden.
     * @return type 
     */
    public function getPublishedPages() {
        $pages = $this->pageDao->getPublishedPages();
        return $pages;
    }

    public function findPageById($id) {
        $entity = NULL;
        if (strlen($id) > 0) {
            $entity = $this->pageDao->findById($id);
        }
        return $entity;
    }

    /**
     * 
     * @param string $permalink
     * @return Page $page.
     */
    public function getPageByPermalink($permalink) {
        return $this->pageDao->getByPermalink($permalink);
    }

    public function getPagesByPermalinkAprox($permalink) {
        return $this->pageDao->getBySimilarPermalink($permalink);
    }

    public function delete(Page $page) {
        $this->pageDao->delete($page);
    }

}

?>
