<script type="text/javascript">

    function actualizarPagina(valor) {
        $('#pagina-sel').val(valor);
        actualizarLista();
    }
    function actualizarLista() {
        var paginaSel = $('#pagina-sel').val();
        var searchSel = $('#search').val();

        var url = "#!adminBlog/index";
        if (paginaSel) {
            url += "/page/" + paginaSel.toLowerCase();
        }
        if (searchSel) {
            url += "/search/" + encodeURI(searchSel);
        }
        window.location = url;
    }
    $(document).ready(function() {
        $("#search").focus(function() {
            $(this).keyup(function(e) {
                if (e.keyCode === 13) {
                    actualizarLista();
                }
            });
        });
        $("#search").focus();
    });
</script>

<div class="page-header">
    <h1>Posts
        <a class="btn create" onclick='createEntity("New Post", "/adminBlog/createPost", "/adminBlog/savePost");' data-form="/adminBlog/createPost" data-form-action="/adminBlog/savePost" ><i class="icon-plus icon-white"></i> Nuevo</a>
    </h1>
</div>


<div action="#!adminBlog/index" method="post" class="form-search">
    <div class="input-append">
        <input id="search" type="text" name="search" placeholder="Buscar…" class="span8 search-query" value="<?php echo $viewData['filter'] ?>">
        <button type="button" class="btn" onclick="actualizarLista()" ><i class="icon-search icon-white"></i> Buscar</button>
    </div>
</div>

<table class="table table-condensed">
    <thead>
    <th>#</th>
    <th>Titulo</th> 
    <th>Descripci&oacute;n</th>
    <th>Fecha</th>
    <th>Acciones</th>
</thead>
<?php foreach ($viewData['pager']->getItems() as $entidad): ?>
    <tr>
        <td><?php echo $entidad->getId() ?></td>
        <td><?php echo $entidad->getTitle() ?></td>
        <td><?php echo $entidad->getDescription() ?></td>
        <td><?php echo $entidad->getDate() ?></td>
        <td>
            <a title="Editar" onclick="updateEntity('Edit Post', '/adminBlog/editPost/<? echo $entidad->getId() ?>', '/adminBlog/savePost')" class="btn btn-mini" ><li class="icon-edit icon-white"></li></a>
            <a title="Eliminar" class="btn btn-mini btn-danger" onclick="if (confirm('Estás seguro?')) {
                deleteEntity('/adminBlog/deletePost/<? echo $entidad->getId() ?>');
            }
            return false;"><li class="icon-remove icon-white"></li></a>
        </td>
    </tr>
<?php endforeach; ?>
</table>
<p class="pull-right">
    Total de <?php echo $viewData['pager']->getItemCount() ?> noticias.
</p>
<input type="hidden" id="pagina-sel" value="" />
<ul class="pager">
    <li><a class="previous" onclick="actualizarPagina(<?php echo $viewData['pager']->getPrevPage() ?>)"><i class="icon-chevron-left icon-white"></i></a></li>
    <span>pagina</span>
    <strong><?php echo $viewData['page'] ?></strong>
    <span>de <?php echo $viewData['pager']->getPageCount() ?></span>
    <li><a class="next" onclick="actualizarPagina(<?php echo $viewData['pager']->getNextPage() ?>)"><i class="icon-chevron-right icon-white"></i></a></li>
</ul>
