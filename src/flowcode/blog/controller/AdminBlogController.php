<?php

namespace flowcode\blog\controller;

use flowcode\blog\domain\Post;
use flowcode\blog\domain\Tag;
use flowcode\blog\service\PostService;
use flowcode\blog\service\TagService;
use flowcode\smooth\mvc\Controller;
use flowcode\smooth\mvc\HttpRequest;
use flowcode\smooth\mvc\View;
use flowcode\smooth\utils\PermalinkBuilder;

/**
 * Description of AdminNoticia
 *
 * @author Juan Manuel Aguero. 
 */
class AdminBlogController extends Controller {

    private $postService;

    function __construct() {
        $this->setIsSecure(TRUE);
        $this->addAllowedRole('admin');
        $this->postService = new PostService();
    }

    function index(HttpRequest $httpRequest) {

        $viewData['filter'] = $httpRequest->getParameter('search');

        $viewData['page'] = $httpRequest->getParameter('page');
        if (is_null($viewData['page']) || empty($viewData['page'])) {
            $viewData['page'] = 1;
        }

        $viewData['pager'] = $this->postService->findByFilter($viewData['filter'], $viewData['page']);

        return View::getControllerView($this, "blog/view/post/postList", $viewData);
    }

    /**
     * Acceder a la creacion de una nueva entidad.
     * @param type $HttpRequest 
     */
    public function createPost($HttpRequest) {

        $viewData['post'] = new Post();

        // tags
        $tagSrv = new TagService();
        $viewData['tags'] = $tagSrv->findAll();

        return View::getControllerView($this, "blog/view/post/postForm", $viewData);
    }

    /**
     * Guardar una entidad.
     * @param type $HttpRequest 
     */
    function savePost(HttpRequest $httpRequest) {

        // obtengo los datos
        $title = $httpRequest->getParameter("title");

        $id = (isset($_POST['id']) && !empty($_POST['id'])) ? $_POST['id'] : NULL;
        $permalink = (isset($_POST['permalink']) && !empty($_POST['permalink'])) ? $_POST['permalink'] : $this->buildPermalink($title);

        $imageSlot = $httpRequest->getParameter('image_slot');
        $imageSlotTop = $httpRequest->getParameter('bgtop');
        $imageSlotLeft = $httpRequest->getParameter('bgleft');
        $imageSlotSize = $httpRequest->getParameter('bgsize');

        $tags = array();
        if (isset($_POST['tags'])) {
            foreach ($_POST['tags'] as $idTag) {
                $tag = new Tag();
                $tag->setId($idTag);
                $tags[] = $tag;
            }
        }

        // creo la nueva instancia y seteo valores
        $post = new Post();
        $post->setId($id);
        $post->setPermalink($permalink);
        $post->setTitle($title);
        $post->setBody($httpRequest->getParameter("body"));
        $post->setIntro($httpRequest->getParameter("intro"));
        $post->setType($httpRequest->getParameter("type"));
        $post->setDate($httpRequest->getParameter("date"));
        $post->setImageSlot($imageSlot);
        $post->setImageSlotLeft($imageSlotLeft);
        $post->setImageSlotTop($imageSlotTop);
        $post->setImageSlotSize($imageSlotSize);
        $post->setTags($tags);

        // la guardo
        $id = $this->postService->save($post);

        $this->redirect("/adminBlog/index");
    }

    /**
     * Modificar una entidad.
     * @param type $HttpRequest 
     */
    function editPost($HttpRequest) {

        // en el primer parametro tiene que venir el id
        $params = $HttpRequest->getParams();
        $id = $params[0];

        $post = $this->postService->findById($id);
        $viewData['post'] = $post;

        // tags
        $tagSrv = new TagService();
        $viewData['tags'] = $tagSrv->findAll();

        return View::getControllerView($this, "blog/view/post/postForm", $viewData);
    }

    /**
     * Eliminar una entidad.
     * @param type $HttpRequest 
     */
    function eliminar($HttpRequest) {
        // en el primer parametro tiene que venir el id
        $params = $HttpRequest->getParams();
        $id = $params[0];

        $this->noticiaService->eliminarNoticiaPorId($id);

        $this->redirect("/adminNoticia/index");
    }

    private function buildPermalink($title) {

        $permalinkBuilder = new PermalinkBuilder();
        $permalinkBuilder->setInputString($title);
        $permalinkBuilder->build();
        $permalink = $permalinkBuilder->getPermalink();

        $posts = $this->postService->getBySimilarPermalink($permalink);
        $permalinkBuilder->setSimilarCount(count($posts));
        $permalinkBuilder->build();
        $permalink = $permalinkBuilder->getPermalink();
        return $permalink;
    }

    public function tags(HttpRequest $httpRequest) {
        $tagSrv = new TagService();
        $viewData['tags'] = $tagSrv->findAll();
        return View::getControllerView($this, "blog/view/post/tags", $viewData);
    }

    public function createTag(HttpRequest $httpRequest) {
        $viewData['tag'] = new Tag();
        return View::getControllerView($this, "blog/view/post/tagForm", $viewData);
    }

    public function saveTag(HttpRequest $httpRequest) {
        $tag = new Tag();
        if ($httpRequest->getParameter("id") != "") {
            $tag->setId($httpRequest->getParameter("id"));
        }
        $tag->setName($httpRequest->getParameter("name"));

        $tagSrv = new TagService();
        $tagSrv->save($tag);
        $this->redirect("/adminBlog/tags");
    }

    public function deleteTag(HttpRequest $httpRequest) {
        $p = $httpRequest->getParams();
        $idTag = $p[0];
        $tagSrv = new TagService();
        $category = $tagSrv->findById($idCategory);
        $tagSrv->delete($category);
        $this->redirect("/adminPost/tags");
    }

}

?>
