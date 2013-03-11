<div class="page-header">
    <h1>Menu
        <small>Crear</small>
    </h1>
</div>
<form action="/adminMenu/save" method="post">
    <input type="hidden" name="id" id="menu-id" value="<?php echo $viewData['menu']->getId() ?>" />
    <div>
        <label>Nombre</label>
        <input type="text" name="name" value="<?php echo $viewData['menu']->getName() ?>"/>
    </div>
    <br/>
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="/adminMenu/index" class="btn">Cancelar</a>
    </div>
</form>