<div class="page-header">
    <h1>Role</h1>
</div>

<form action="/adminRole/save" method="post" class="form-horizontal">
    <input type="hidden" name="id" value="<?php echo $viewData['role']->getId() ?>" />
    <div class="control-group">
        <label class="control-label" for="name">Nombre</label>
        <div class="controls">
            <input type="text" name="name" id="nombre" value="<?php echo $viewData['role']->getName() ?>"/>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label">Permissions</label>
        <div class="controls">
            <select multiple="multiple" name="permissions[]" style="height: 137px;">
                <?php foreach ($viewData['permissions'] as $permission): ?>
                    <?php
                    $checked = "";
                    foreach ($viewData['role']->getPermissions() as $postPermission) {
                        if ($permission->getId() == $postPermission->getId()) {
                            $checked = "selected";
                            break;
                        }
                    }
                    ?>
                    <option <?php echo $checked; ?> value="<?php echo $permission->getId(); ?>" ><?php echo $permission; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary btn-large">Guardar</button>
        <a href="/adminRole/index" class="btn btn-large">Cancelar</a>
    </div>

</form>

