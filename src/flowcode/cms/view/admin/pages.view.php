<div class="page-header">
    <h1>Paginas
        <a class="btn" href="/adminPage/create" ><li class="icon-plus icon-white"></li> Nueva</a>
    </h1>
</div>


<form action="/adminPage/pages" method="post" class="form-search">
    <div class="input-append">
        <input id="search" type="text" name="search" placeholder="Buscar…" class="span-9 search-query" value="<?php echo $viewData['filter'] ?>"/>
        <button type="submit"class="btn"><li class="icon-search icon-white"></li> Buscar</button>
    </div>
</form>

<table class="table table-condensed">
    <thead>
        <th>#</th>
        <th>Nombre</th>
        <th>Descripcion</th>
        <th>Estado</th>
        <th>Tipo</th>
        <th>Acciones</th>
    </thead>
<?php foreach ($viewData["pager"]->getItems() as $entidad): ?>
    <tr>
        <td><div><?php echo $entidad->getId() ?></div></td>
        <td><div style = "width: 150px; height: 35px; overflow: hidden;"><?php echo $entidad->getName() ?></div></td>
        <td><div style = "width: 300px; height: 35px; overflow: hidden;"><?php echo $entidad->getDescription() ?></div></td>
        <td><?php echo $entidad->getStatus() ?></td>
        <td><?php echo $entidad->getType() ?></td>
        <td>
            <a title="Editar" href="<?php echo "/adminPage/edit/id/" . $entidad->getId() ?>" class="btn btn-mini" ><li class="icon-edit icon-white"></li></a>
            <a title="Eliminar" href="<?php echo "/adminPage/delete/id/" . $entidad->getId() ?>" class="btn btn-mini btn-danger" onclick="if(confirm('Estás seguro?')){return true;}return false;" ><li class="icon-remove icon-white"></li></a>
        </td>
    </tr>
<?php endforeach; ?>
</table>
<p class="pull-right">
    Total de <?php echo $viewData['pager']->getItemCount() ?> paginas.
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
     
        var url = "/adminPage/pages";
        if( paginaSel ){
            url += "/page/" + paginaSel.toLowerCase();
        }
        window.location =  url;
    }
</script>