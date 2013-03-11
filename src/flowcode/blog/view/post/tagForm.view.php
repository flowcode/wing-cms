<div class="page-header">
    <h1>Tag</h1>
</div>

<form action="/adminBlog/saveTag" method="post" class="form-horizontal">
    <input type="hidden" name="id" value="<?php echo $viewData['tag']->getId() ?>" />

    <div class="control-group">
        <label class="control-label" for="name">Nombre</label>
        <div class="controls">
            <input type="text" id="name" name="name" placeholder="nombre..." value="<?php echo $viewData['tag']->getName() ?>">
        </div>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Guardar cambios</button>
        <a href="/adminBlog/tags" class="btn">Cancelar</a>
    </div>
</form>
