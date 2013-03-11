<input type="hidden" name="id" id="menu-id" value="<?php echo $menu->getId() ?>" />
<div>
    <label>Nombre</label>
    <input type="text" name="name" value="<?php echo $menu->getNombre() ?>"/>
</div>
<div class="admin-categoria">
    <label>Estado</label>
    <select id="estado" name="estado">
        <option value="A">Activo</option>
        <option value="N">No activo</option>
    </select>
</div>