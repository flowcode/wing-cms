<div class="page-header">
    <h1>Menus
        <small>Incorporados en el sistema</small>
    </h1>
</div>

<table class="table table-striped table-bordered table-condensed">
    <thead>
    <th>#</th>
    <th>Nombre</th>
    <th>Acciones</th>
</thead>
<?php foreach ($viewData['menus'] as $entidad): ?>
    <tr>
        <td><div><?php echo $entidad->getId() ?></div></td>
        <td><div style = "width: 150px; height: 35px; overflow: hidden;"><?php echo $entidad->getName() ?></div></td>
        <td>
            <a title="Editar" href="<?php echo "/adminMenu/edit/" . $entidad->getId() ?>" class="btn btn-mini" ><li class="icon-edit"></li></a>
            <a title="Eliminar" href="<?php echo "/adminMenu/delete/" . $entidad->getId() ?>" class="btn btn-mini btn-danger" onclick="if(confirm('Estás seguro?')){return true;}return false;" ><li class="icon-remove"></li></a>
        </td>
    </tr>
<?php endforeach; ?>
</table>
