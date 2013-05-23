<?php $edita = FALSE; ?>
<?php if ($viewData['user']->getId() && $viewData['user']->getId() != -1 && $viewData['user']->getId() != NULL): ?>
    <?php $edita = TRUE; ?>
    <form action="<?php echo "/adminUser/saveEdit" ?>" method="post" class="form-horizontal form">
        <input type="hidden" name="id" value="<?php echo $viewData['user']->getId() ?>" />
    <?php else: ?>
        <form action="<?php echo "/adminUser/save" ?>" method="post" class="form-horizontal form">
        <?php endif; ?>
        <div class="control-group">
            <label class="control-label" for="name">Nombre</label>
            <div class="controls">
                <input type="text" name="name" id="nombre" value="<?php echo $viewData['user']->getName() ?>"/>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="username">Username</label>
            <div class="controls">
                <input type="text" name="username" id="username" value="<?php echo $viewData['user']->getUsername() ?>"/>
            </div>
        </div>

        <div class="control-group">
            <?php if ($edita): ?>
                <label class="control-label" for="password">Nuevo Password</label>
                <div class="controls">
                    <input type="password" name="password" id="password" value=""/>
                    <span class="label label-important">Dejar en blanco para mantener pass anterior</span>
                </div>
            <?php else: ?>
                <label class="control-label" for="password">Password</label>
                <div class="controls">
                    <input type="password" name="password" id="password" value=""/>
                </div>
            <?php endif; ?>
        </div>
        <div class="control-group">
            <label class="control-label">Roles</label>
            <div class="controls">
                <select multiple="multiple" name="roles[]" style="height: 137px;">
                    <?php foreach ($viewData['roles'] as $role): ?>
                        <?php
                        $checked = "";
                        foreach ($viewData['user']->getRoles() as $postRole) {
                            if ($role->getId() == $postRole->getId()) {
                                $checked = "selected";
                                break;
                            }
                        }
                        ?>
                        <option <?php echo $checked; ?> value="<?php echo $role->getId(); ?>" ><?php echo $role; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>


        <div class="control-group">
            <label class="control-label" for="mail">Mail</label>
            <div class="controls">
                <input type="text" name="mail" value="<?php echo $viewData['user']->getMail() ?>"/>
            </div>
        </div>


    </form>

