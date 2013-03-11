
<div class="page-header">
    <h1>Tags
        <a class="btn" href="/adminBlog/createTag" >Nuevo</a>
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
                <a title="Modificar" href="<?php echo "/adminBlog/editTag/" . $categoria->getId() ?>" class="btn btn-mini" ><i class="icon-edit"></i></a>
                <a title="Eliminar" href="<?php echo "/adminBlog/deleteTag/" . $categoria->getId() ?>" class="btn btn-mini btn-danger" onclick="if(confirm('Estás seguro?')){return true;}return false;" ><i class="icon-remove"></i></a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
