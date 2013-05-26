<form action="/adminBlog/saveTag" method="post" class="form-horizontal form">
    <input type="hidden" name="id" value="<?php echo $viewData['tag']->getId() ?>" />

    <div class="control-group">
        <label class="control-label" for="name">Nombre</label>
        <div class="controls">
            <input type="text" id="name" name="name" placeholder="nombre..." value="<?php echo $viewData['tag']->getName() ?>">
        </div>
    </div>
</form>
