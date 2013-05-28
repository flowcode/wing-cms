<form class="form-horizontal form">
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

</form>

