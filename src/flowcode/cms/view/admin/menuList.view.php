<div class="page-header">
    <h1>Menus
        <small>Incorporados en el sistema</small>
    </h1>
</div>

<table class="table table-condensed">
    <thead>
        <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($viewData['menus'] as $entidad): ?>
            <tr>
                <td><div><?php echo $entidad->getId() ?></div></td>
                <td><div style = "width: 150px; height: 35px; overflow: hidden;"><?php echo $entidad->getName() ?></div></td>
                <td>
                    <a title="Editar" onclick="updateEntity('Update Menu','/adminMenu/edit/<? echo $entidad->getId() ?>','' )" class="btn btn-mini" ><li class="icon-edit icon-white"></li></a>
                    <a title="Eliminar" href="<?php echo "/adminMenu/delete/" . $entidad->getId() ?>" class="btn btn-mini btn-danger" onclick="if (confirm('Estás seguro?')) {
                                return true;
                            }
                            return false;" ><li class="icon-remove icon-white"></li></a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
