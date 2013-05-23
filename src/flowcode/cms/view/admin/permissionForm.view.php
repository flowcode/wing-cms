<form action="/adminPermission/save" method="post" class="form-horizontal form">
    <input type="hidden" name="id" value="<?php echo $viewData['permission']->getId() ?>" />
    <div class="control-group">
        <label class="control-label" for="name">Nombre</label>
        <div class="controls">
            <input type="text" name="name" id="nombre" value="<?php echo $viewData['permission']->getName() ?>"/>
        </div>
    </div>

</form>

