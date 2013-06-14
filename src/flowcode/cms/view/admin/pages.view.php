<div class="page-header">
    <h1>Paginas
        <a class="btn create" onclick='createEntity("New Tag", "/adminPage/create", "/adminPage/save");' ><li class="icon-plus icon-white"></li> Nueva</a>
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
    <th>Permalink</th>
    <th>Descripcion</th>
    <th>Estado</th>
    <th>Tipo</th>
    <th>Acciones</th>
</thead>
<?php foreach ($viewData["pager"]->getItems() as $entidad): ?>
    <tr>
        <td><div><?php echo $entidad->getId() ?></div></td>
        <td><?php echo $entidad->getName() ?></td>
        <td><?php echo $entidad->getPermalink() ?></td>
        <td><div style = "width: 300px; height: 35px; overflow: hidden;"><?php echo $entidad->getDescription() ?></div></td>
        <td><?php echo $entidad->getStatus() ?></td>
        <td><?php echo $entidad->getType() ?></td>
        <td>
            <a title="Editar" onclick="updateEntity('Update Page', '/adminPage/edit/id/<? echo $entidad->getId() ?>', '/adminPage/save')" class="btn btn-mini" ><li class="icon-edit icon-white"></li></a>
            <a title="Eliminar" class="btn btn-mini btn-danger" onclick="if (confirm('Estás seguro?')) {
                        return true;
                    }
                    return false;" onclick="deleteEntity('<? echo "/adminPage/delete/id/" . $entidad->getId() ?>')" ><li class="icon-remove icon-white"></li></a>
        </td>
    </tr>
<?php endforeach; ?>
</table>
<p class="pull-right">
    Total de <?php echo $viewData['pager']->getItemCount() ?> paginas.
</p>
<input type="hidden" id="pagina-sel" value="" />
<ul class="pager">
    <li><a class="previous" onclick="actualizarPagina(<?php echo $viewData['pager']->getPrevPage() ?>)"><i class="icon-chevron-left icon-white"></i></a></li>
    <span>pagina</span>
    <strong><?php echo $viewData['page'] ?></strong>
    <span>de <?php echo $viewData['pager']->getPageCount() ?></span>
    <li><a class="next" onclick="actualizarPagina(<?php echo $viewData['pager']->getNextPage() ?>)"><i class="icon-chevron-right icon-white"></i></a></li>
</ul>
<script>
            $(document).ready(function() {
                $("#search").focus();
            });
            function actualizarPagina(valor) {
                $('#pagina-sel').val(valor);
                actualizarLista();
            }
            function actualizarLista() {
                var paginaSel = $('#pagina-sel').val();

                var url = "/adminPage/pages";
                if (paginaSel) {
                    url += "/page/" + paginaSel.toLowerCase();
                }
                window.location = url;
            }
</script>