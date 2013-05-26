<div class="page-header">
    <h1>Tags
        <a class="btn create" onclick='createEntity("New Tag", "/adminBlog/createTag", "/adminBlog/saveTag");' ><i class="icon-plus icon-white"></i> Nuevo</a>
    </h1>
</div>

<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <?php foreach ($viewData['tags'] as $categoria): ?>
        <tr>
            <td><?php echo $categoria->getId() ?></td>
            <td><?php echo $categoria->getName() ?></td>
            <td>
                <a title="Modificar" class="btn btn-mini" onclick="updateEntity('Update Tag', '/adminBlog/editTag/<? echo $categoria->getId() ?>', '/adminBlog/saveTag')" ><i class="icon-edit icon-white"></i></a>
                <a title="Eliminar" onclick="deleteEntity('<? echo "/adminBlog/deleteTag/" . $categoria->getId() ?>')" class="btn btn-mini btn-danger" onclick="if (confirm('Estás seguro?')) {
                        return true;
                    }
                    return false;" ><i class="icon-remove icon-white"></i></a>

            </td>
        </tr>
    <?php endforeach; ?>
</table>
