<?php

namespace flowcode\blog\dao;

use Exception;
use flowcode\blog\domain\Post;
use flowcode\orm\EntityManager;
use flowcode\wing\mvc\DataSource;
use flowcode\wing\utils\Pager;

class PostDao {

    private $dataSource;

    public function __construct() {
        $this->dataSource = new DataSource();
    }

    public function save(Post $post) {
        $em = EntityManager::getInstance();
        $em->save($post);
    }

    public function findById($id) {
        $em = EntityManager::getInstance();
        return $em->findById("post", $id);
    }

    /**
     * Delete entity from database.
     * @param Post $post 
     */
    function delete(Post $post) {
        $em = EntityManager::getInstance();
        $em->delete($post);
    }

    /**
     * Find entitys by the configured filter.
     * @param type $filter
     * @param type $page
     * @return Pager
     */
    public function findByFilter($filter = null, $page = 1) {
        $em = EntityManager::getInstance();
        $pager = $em->findByGenericFilter("post", $filter, $page, "date", "desc");
        return $pager;
    }

    /**
     * Get post with similar permalinks.
     * @param String $permalink
     * @return array
     */
    public function getBySimilarPermalink($permalink) {

        $em = EntityManager::getInstance();
        $posts = $em->findByWhereFilter("post", "permalink LIKE '$permalink%' ", "date", "desc");

        return $posts;
    }

    public function findByPermalink($permalink) {
        $post = NULL;
        $em = EntityManager::getInstance();
        $posts = $em->findByWhereFilter("post", "permalink = '$permalink' ", "date", "desc");
        if (count($posts) > 0) {
            $post = $posts[0];
        }
        return $post;
    }

    /**
     * 
     */
    function findByTagYearMonth($tag, $year, $month, $page = 1) {
        $cantSlotsPorPagina = 2;
        $desde = ($page-1) * $cantSlotsPorPagina;

        $selectQuery = "";

        $selectQuery = "SELECT * FROM post p ";
        $id = 'id';
        if (isset($tag) && $tag != null) {
            $selectQuery .= ", post_tag pt, tag t ";
        }

        $whereQuery = " WHERE 1=1 ";
        if (isset($tag) && $tag != null) {
            $whereQuery .= "AND pt.id_post = p.id ";
            $whereQuery .= "AND pt.id_tag = t.id ";
            $whereQuery .= "AND t.name = '" . $tag . "' ";
            $id = 'id_noticia';
        }
        if (isset($year) && $year != null) {
            $whereQuery .= " AND YEAR(p.date) = '" . $year . "'";
        }
        if (isset($month) && $month != null) {
            $whereQuery .= " AND MONTH(p.date) = '" . $month . "'";
        }
        $orderQuery = " ORDER BY p.date DESC ";
        $pageQuery = " LIMIT $desde , $cantSlotsPorPagina ";

        $noticias = array();
        $query = $selectQuery . $whereQuery . $orderQuery . $pageQuery;

        $result = $this->dataSource->executeQuery($query);
        if ($result) {
            foreach ($result as $fila) {
                $entity = new Post();
                $em = EntityManager::getInstance();
                $em->populateEntity($entity, $fila);
                $noticias[] = $entity;
            }
        }

        $selectCountQuery = "SELECT count(*) as total FROM post p ";
        $id = 'id';
        if (isset($tag) && $tag != null) {
            $selectCountQuery .= ", post_tag pt, tag t ";
        }
        $query = $selectCountQuery . $whereQuery;
        $result = $this->dataSource->executeQuery($query);
        $itemCount = $result[0]["total"];
        $pager = new Pager($noticias, $itemCount, $cantSlotsPorPagina, $page);

        return $pager;
    }

    public function findTags(Post $post) {
        $em = EntityManager::getInstance();
        $tags = $em->findRelation($post, "Tags");
        return $tags;
    }

}

?>
