<?php

namespace flowcode\blog\service;

use Exception;
use flowcode\blog\dao\PostDao;
use flowcode\blog\domain\Post;
use flowcode\wing\mvc\Config;

/**
 * 
 */
class PostService {

    private $postDao;

    function __construct() {
        $this->postDao = new PostDao();
    }

    /**
     * Save a post.
     * @param \flowcode\blog\domain\Post $post
     * @return type
     */
    public function save(Post $post) {
        $id = $this->postDao->save($post);
        return $id;
    }

    /**
     * Obtiene todas las Noticias.
     * @return type 
     */
    public function findByFilter($filter = null, $page = 1) {
        $pager = $this->postDao->findByFilter($filter, $page);
        return $pager;
    }

    /**
     * Obtiene noticas filtradas.
     * @return type 
     */
    public function findByTag($tag, $year, $month, $page = 1) {
        $pager = $this->postDao->findByTagYearMonth($tag, $year, $month, $page);
        return $pager;
    }

    public function findById($id) {
        return $this->postDao->findById($id);
    }

    public function findByPermalink($permalink) {
        $post = $this->postDao->findByPermalink($permalink);
        return $post;
    }

    /**
     * Gets posts with similar permalinks.
     * @return array $posts
     */
    public function getBySimilarPermalink($permalink) {
        $posts = $this->postDao->getBySimilarPermalink($permalink);
        return $posts;
    }

    /**
     * Elimina la Noticia correspondiente al id.
     * 
     * @param type $id 
     */
    public function delete(Post $post) {
        $this->postDao->delete($post);
    }

    public function findTagsByPost(Post $post) {
        return $this->postDao->findTags($post);
    }

}

?>
