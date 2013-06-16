<?php

namespace flowcode\blog\controller;

use flowcode\blog\domain\Post;
use flowcode\blog\domain\Tag;
use flowcode\blog\service\PostService;
use flowcode\blog\service\TagService;
use flowcode\wing\mvc\BareView;
use flowcode\wing\mvc\Controller;
use flowcode\wing\mvc\HttpRequest;
use flowcode\wing\utils\PermalinkBuilder;

/**
 * Description of AdminNoticia
 *
 * @author Juan Manuel Aguero. 
 */
class AdminBlogController extends Controller {

    private $postService;

    function __construct() {
        $this->setIsSecure(TRUE);
        $this->addPermission("admin-blog-post-create");
        $this->addPermission("admin-blog-post-edit");
        $this->addPermission("admin-blog-post-delete");
        $this->postService = new PostService();
    }

    function index(HttpRequest $httpRequest) {

        $viewData['filter'] = $httpRequest->getParameter('search');

        $viewData['page'] = $httpRequest->getParameter('page');
        if (is_null($viewData['page']) || empty($viewData['page'])) {
            $viewData['page'] = 1;
        }

        $viewData['pager'] = $this->postService->findByFilter($viewData['filter'], $viewData['page']);
        return new BareView($viewData, "blog/view/post/postList");
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

        return new BareView($viewData, "blog/view/post/postForm");
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
        $post->setDescription($httpRequest->getParameter("description"));
        $post->setIntro($httpRequest->getParameter("intro"));
        $post->setBody($httpRequest->getParameter("body"));
        $post->setType($httpRequest->getParameter("type"));
        $post->setDate($httpRequest->getParameter("date"));
        $post->setTags($tags);

        // la guardo
        $id = $this->postService->save($post);

        $viewData['response'] = "success";
        return new BareView($viewData, "cms/view/admin/form-response");
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

        return new BareView($viewData, "blog/view/post/postForm");
    }

    /**
     * Eliminar una entidad.
     * @param type $HttpRequest 
     */
    function deletePost($HttpRequest) {
        // en el primer parametro tiene que venir el id
        $params = $HttpRequest->getParams();
        $id = $params[0];

        $post = $this->postService->findById($id);
        $this->postService->delete($post);

        $viewData['response'] = "success";
        return new BareView($viewData, "cms/view/admin/form-response");
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
        $viewData['filter'] = $httpRequest->getParameter('search');
        
        $viewData['page'] = $httpRequest->getParameter('page');
        if (is_null($viewData['page']) || empty($viewData['page'])) {
            $viewData['page'] = 1;
        }

        $viewData['pager'] = $tagSrv->findByFilter($viewData['filter'], $viewData['page']);
        
        return new BareView($viewData, "blog/view/post/tags");
    }

    public function createTag(HttpRequest $httpRequest) {
        $viewData['tag'] = new Tag();
        return new BareView($viewData, "blog/view/post/tagForm");
    }

    public function editTag(HttpRequest $httpRequest) {

        // en el primer parametro tiene que venir el id
        $params = $httpRequest->getParams();
        $id = $params[0];

        $tagSrv = new TagService();
        $viewData['tag'] = $tagSrv->findById($id);
        return new BareView($viewData, "blog/view/post/tagForm");
    }

    public function saveTag(HttpRequest $httpRequest) {
        $tag = new Tag();
        if ($httpRequest->getParameter("id") != "") {
            $tag->setId($httpRequest->getParameter("id"));
        }
        $tag->setName($httpRequest->getParameter("name"));

        $tagSrv = new TagService();
        $tagSrv->save($tag);

        $viewData['response'] = "success";
        return new BareView($viewData, "cms/view/admin/form-response");
    }

    public function deleteTag(HttpRequest $httpRequest) {
        $p = $httpRequest->getParams();
        $idTag = $p[0];
        $tagSrv = new TagService();
        $tag = $tagSrv->findById($idTag);
        $tagSrv->delete($tag);

        $viewData['response'] = "success";
        return new BareView($viewData, "cms/view/admin/form-response");
    }

}

?>
