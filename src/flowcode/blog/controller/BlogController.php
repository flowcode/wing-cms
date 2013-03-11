<?php

namespace flowcode\naranja\controller;

use flowcode\naranja\domain\Noticia;
use flowcode\naranja\service\DateService;
use flowcode\naranja\service\NoticiaService;
use flowcode\wing\mvc\Controller;
use flowcode\wing\mvc\HttpRequest;

class BlogController extends Controller {

    private $noticiaService;

    function __construct() {
        $this->noticiaService = new NoticiaService();
        $this->setIsSecure(false);
    }
    
    public function index(HttpRequest $request){
        include "view/noticia/noticiaLista.view.php";
    }

    public function posts(HttpRequest $request) {


        $categoriaSel = $request->getParameter("categoriaSel");
        $anioSel = $request->getParameter("anioSel");
        $mesSel = $request->getParameter("mesSel");
        $paginaSel = $request->getParameter("paginaSel");

        $paginador = $this->noticiaService->obtenerNoticiasFiltradas(Noticia::$publica, $categoriaSel, $anioSel, $mesSel, $paginaSel);
        $noticias = $paginador['lista'];
        $paginaSiguiente = $paginador['siguiente'];
        $paginaAnterior = $paginador['anterior'];
        $categorias = $this->noticiaService->obtenerCategorias();
        $dateService = new DateService();
        $anios = $dateService->getYears();
        $meses = $dateService->getMonths();

        header("application/json");
        echo $this->toJson($noticias);
    }

    public function post($httpRequest) {

        $params = $httpRequest->getParams();
        $id = $params[0];

        $noticia = $this->noticiaService->obtenerNoticiaPorPermalink($id);

        include "view/noticia/noticia.view.php";
    }

}

?>
