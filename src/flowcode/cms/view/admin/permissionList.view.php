<script type="text/javascript">
    $(document).ready(function() {
        $(".create").click(function() {
            createEntity("Create Permission", "/adminPermission/create", "/adminPermission/save");
        });
    });
</script>
<div class="page-header">
    <h1>Permissions
        <a class="btn create" ><i class="icon-plus icon-white"></i> Nuevo</a>
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
        <?php foreach ($viewData['permissions'] as $entity): ?>
            <tr>
                <td><?php echo $entity->getId() ?></td>
                <td><?php echo $entity->getName() ?></div></td>
                <td>
                    <a class="btn btn-mini" onclick="updateEntity('Update Permission','/adminPermission/edit/<? echo $entity->getId() ?>', '/adminPermission/save')" ><i class="icon-edit icon-white"></i></a>
                    <a onclick="deleteEntity('<? echo "/adminPermission/delete/" . $entity->getId() ?>')" class="btn btn-mini btn-danger" onclick="if (confirm('Estás seguro?')) {
                return true;
            }
            return false;" ><i class="icon-remove icon-white"></i></a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
