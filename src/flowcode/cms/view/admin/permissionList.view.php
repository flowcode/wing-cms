<script type="text/javascript">
    function actualizarPagina(valor) {
        $('#pagina-sel').val(valor);
        actualizarLista();
    }
    function actualizarLista() {
        var paginaSel = $('#pagina-sel').val();
        var searchSel = $('#search').val();

        var url = "#!adminPermission/index";
        if (paginaSel) {
            url += "/page/" + paginaSel.toLowerCase();
        }
        if (searchSel) {
            url += "/search/" + encodeURI(searchSel);
        }
        window.location = url;
    }
    $(document).ready(function() {
        /* search form */
        $("#search").focus(function() {
            $(this).keyup(function(e) {
                if (e.keyCode === 13) {
                    actualizarLista();
                }
            });
        });
        $("#search").focus()

        /* create */
        $(".page-header > h1 > a").click(function() {
            createEntity("Create Permission", $(this).attr("data-form"), $(this).attr("data-form-action"));
        });

        /* update */
        $("a.edit").click(function() {
            updateEntity("Edit Permission", "/adminPermission/edit/" + $(this).attr("data-form-entity"), "/adminPermission/save");
        });

        /* delete */
        $("a.delete").click(function() {
            if (confirm('Estás seguro?')) {
                deleteEntity("adminPermission/delete/" + $(this).attr("data-form-entity"));
            }
        });
    });
</script>
<div class="page-header">
    <h1>Permissions
        <a class="btn create" data-form="/adminPermission/create" data-form-action="/adminPermission/save" ><i class="icon-plus icon-white"></i> Nuevo</a>
    </h1>
</div>

<div class="form-search">
    <div class="input-append">
        <input id="search" type="text" name="search" placeholder="Buscar…" class="span8 search-query" value="<?php echo $viewData['filter'] ?>">
        <button type="button" class="btn" onclick="actualizarLista()" ><i class="icon-search icon-white"></i> Buscar</button>
    </div>
</div>

<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($viewData['pager']->getItems() as $entity): ?>
            <tr>
                <td><?php echo $entity->getId() ?></td>
                <td><?php echo $entity->getName() ?></div></td>
                <td style="width: 100px;">
                    <a class="btn btn-mini edit" data-form-entity="<? echo $entity->getId() ?>" ><i class="icon-edit icon-white"></i></a>
                    <a data-form-entity="<? echo $entity->getId() ?>" class="btn btn-mini btn-danger delete"><i class="icon-remove icon-white"></i></a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<p class="pull-right">
    Total de <?php echo $viewData['pager']->getItemCount() ?> roles.
</p>
<input type="hidden" id="pagina-sel" value="" />
<ul class="pager">
    <li><a class="previous" onclick="actualizarPagina(<?php echo $viewData['pager']->getPrevPage() ?>)"><i class="icon-chevron-left icon-white"></i></a></li>
    <span>pagina</span>
    <strong><?php echo $viewData['page'] ?></strong>
    <span>de <?php echo $viewData['pager']->getPageCount() ?></span>
    <li><a class="next" onclick="actualizarPagina(<?php echo $viewData['pager']->getNextPage() ?>)"><i class="icon-chevron-right icon-white"></i></a></li>
</ul>