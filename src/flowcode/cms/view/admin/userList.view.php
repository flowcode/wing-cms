<div class="page-header">
    <h1>Usuarios del sistema
        <a class="btn" onclick='createEntity("Create usuario","/adminUser/create", "/adminUser/save");'><i class="icon-plus icon-white"></i> Nuevo</a>
    </h1>
</div>

<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Username</th>
            <th>Name</th>
            <th>Roles</th>
            <th>Mail</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($viewData['users'] as $usuario): ?>
            <tr>
                <td><?php echo $usuario->getId() ?></td>
                <td><?php echo $usuario->getUsername() ?></td>
                <td><?php echo $usuario->getName() ?></div></td>
                <td><?php echo $usuario->getRolesNames() ?></div></td>
                <td><?php echo $usuario->getMail() ?></td>
                <td>
                    <a onclick="updateEntity('Update usurio','<? echo "/adminUser/edit/" . $usuario->getId() ?>', '/adminUser/save')" class="btn btn-mini" ><i class="icon-edit icon-white"></i></a>
                    <a onclick="deleteEntity('<? echo "/adminUser/delete/" . $usuario->getId() ?>')" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i></a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
