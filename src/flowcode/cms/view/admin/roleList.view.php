<div class="page-header">
    <h1>Roles
        <a class="btn" href="/adminRole/create" ><i class="icon-plus icon-white"></i> Nuevo</a>
    </h1>
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
        <?php foreach ($viewData['roles'] as $entity): ?>
            <tr>
                <td><?php echo $entity->getId() ?></td>
                <td><?php echo $entity->getName() ?></div></td>
                <td>
                    <a href="<?php echo "/adminRole/edit/" . $entity->getId() ?>" class="btn btn-mini" ><i class="icon-edit icon-white"></i></a>
                    <a href="<?php echo "/adminRole/delete/" . $entity->getId() ?>" class="btn btn-mini btn-danger" onclick="if (confirm('Estás seguro?')) {
                                return true;
                            }
                            return false;" ><i class="icon-remove icon-white"></i></a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
