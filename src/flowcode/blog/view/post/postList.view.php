<div class="page-header">
    <h1>Posts
        <a class="btn" href="/adminBlog/createPost" ><li class="icon-plus icon-white"></li> Nuevo</a>
    </h1>
</div>


<form action="/adminBlog/index" method="post" class="form-search">
    <div class="input-append">
        <input id="search" type="text" name="search" placeholder="Buscar…" class="span8 search-query" value="<?php echo $viewData['filter'] ?>"/>
        <button type="submit"class="btn"><li class="icon-search icon-white"></li> Buscar</button>
    </div>
</form>

<table class="table table-condensed">
    <thead>
    <th>#</th>
    <th>Titulo</th>
    <th>Intro</th>
    <th>Fecha</th>
    <th>Acciones</th>
</thead>
<?php foreach ($viewData['pager']->getItems() as $entidad): ?>
    <tr>
        <td><?php echo $entidad->getId() ?></div></td>
        <td><div style = "width: 150px; height: 35px; overflow: hidden;"><?php echo $entidad->getTitle() ?></div></td>
        <td><div style = "width: 300px; height: 35px; overflow: hidden;"><?php echo $entidad->getIntro() ?></div></td>
        <td><?php echo $entidad->getDate() ?></td>
        <td>
            <a title="Editar" href="<?php echo "/adminBlog/editPost/" . $entidad->getId() ?>" class="btn btn-mini" ><li class="icon-edit icon-white"></li></a>
            <a title="Eliminar" href="<?php echo "/adminBlog/eliminar/" . $entidad->getId() ?>" class="btn btn-mini btn-danger icon-white" onclick="if(confirm('Estás seguro?')){return true;}return false;"><li class="icon-remove"></li></a>
        </td>
    </tr>
<?php endforeach; ?>
</table>
<p class="pull-right">
    <span class="label">Info</span> Total de <?php echo $viewData['pager']->getItemCount() ?> noticias.
</p>
<input type="hidden" id="pagina-sel" value="" />
<ul class="pager">
    <li><a onclick="actualizarPagina(<?php echo $viewData['pager']->getPrevPage() ?>)">Prev</a></li>
    <span>pagina</span>
    <strong><?php echo $viewData['page'] ?></strong>
    <span>de <?php echo $viewData['pager']->getPageCount() ?></span>
    <li><a onclick="actualizarPagina(<?php echo $viewData['pager']->getNextPage() ?>)">Next</a></li>
</ul>
<script>
    $(document).ready(function(){
        $("#search").focus();
    });
    function actualizarPagina(valor){
        $('#pagina-sel').val(valor);
        actualizarLista();
    }
    function actualizarLista(){
        var paginaSel = $('#pagina-sel').val();
     
        var url = "/adminBlog/index";
        if( paginaSel ){
            url += "/page/" + paginaSel.toLowerCase();
        }
        window.location =  url;
    }
</script>
