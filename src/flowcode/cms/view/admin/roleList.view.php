<script type="text/javascript">
    $(document).ready(function() {
        /* create */
        $(".page-header > h1 > a").click(function() {
            createEntity("New Role", $(this).attr("data-form"), $(this).attr("data-form-action"));
        });

        /* update */
        $("a.edit").click(function() {
            updateEntity("Edit Role", "/adminRole/edit/" + $(this).attr("data-form-entity"), "/adminRole/save");
        });

        /* delete */
        $("a.delete").click(function() {
            if (confirm('Estás seguro?')) {
                deleteEntity("adminRole/delete/" + $(this).attr("data-form-entity"));
            }
        });
    });
</script>
<div class="page-header">
    <h1>Roles
        <a class="btn" data-form="/adminRole/create" data-form-action="/adminRole/save" ><i class="icon-plus icon-white"></i> Nuevo</a>
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
                    <a data-form-entity="<? echo $entity->getId() ?>" class="btn btn-mini edit" ><i class="icon-edit icon-white"></i></a>
                    <a data-form-entity="<? echo $entity->getId() ?>" class="btn btn-mini btn-danger delete"><i class="icon-remove icon-white"></i></a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
