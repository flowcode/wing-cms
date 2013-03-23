<script type="text/javascript">
    function nuevoItem(){
        $("#item-menu-menu-id").val($("#menu-id").val());
        clearItemMenuForm();
        $("#item-menu-form").dialog({
            modal: "true"
        });
    }
    
    function cerrarNuevoItem(){
        $("#item-menu-form").dialog("close");
    }
    
    function doGuardar(){
        guardarOrden();
      
    }
    
    function guardarOrden(){
        var itemsArray = new Array();
        var itemMenus = $(".item-menu");
        for(var l=0; l<itemMenus.length; l++){
            var item = {
                id:  $(itemMenus[l]).attr("id").replace("item-menu-",""),
                orden: l
            }
            itemsArray.push(item);
        }
        $.ajax({
            url: "/adminMenu/saveItemsOrder",
            type: "POST",
            data: {items: itemsArray},
            success: function(data){
                console.log(data);
                var form = document.getElementById("menuForm");
                form.submit();
            },
            error: function(a,b,c){
                console.log(a);
            }
        });
    }
    
    function guardarItem(){

        var item = {
            name: $("#item-menu-nombre").val(),
            pageId: $("#item-menu-seccion").val(),
            menuId: $("#menu-id").val(),
            linkUrl: $("#item-menu-link").val(),
            linTarget: $("#item-menu-linktarget").val(),
            order: $("#item-menu-orden").val(),
            fatherId: $("#item-menu-padre").val()
        }
            
        var url = "/adminMenu/saveItemMenu";
                
        $.ajax({
            url: url,
            type: "post",
            data: {
                name: item.name, 
                pageId: item.pageId,
                linkurl: escape(item.linkUrl),
                linktarget: item.linTarget,
                order: item.order,
                fatherId: item.fatherId,
                menuId: item.menuId
            },
            success: function(savedId){
                item.id = savedId;
                if(item.fatherId != "" && item.fatherId != undefined ){
                    agregarItemHijo("item-menu-"+item.fatherId, item);
                }else{
                    agregarItem(item);
                }
            },
            complete: function(){
                cerrarNuevoItem();
            },
            error: function(){
                alert("error");
            }
        });
    }
    
    function eliminarItem(id){
        
        var url = "/adminMenu/deleteItemMenu";
        url += "/id/"+id;
        
        $.ajax({
            url: url,
            type: "html",
            success: function(data){
                borrarItem(data);
            },
            error: function(){
                alert("error");
            }
        });
    }
    
    function agregarItem(itemObj){
        itemHtml  = "<div id='item-menu-"+itemObj.id+"' class='item-menu' >";
        itemHtml +=     "<span>"+itemObj.order+" |</span>";
        itemHtml +=     "<span>"+itemObj.name+"</span>";
        itemHtml +=     "<a onclick='eliminarItem("+itemObj.id+")'><li class='icon-remove'></li></a>";
        itemHtml +=     "<a onclick='nuevoItemHijo("+itemObj.id+")'><li class='icon-plus'></li></a>";
        itemHtml += "</div>";
        $("#items").append(itemHtml);
    }
    function agregarItemHijo(idPadre, itemObj){
        itemHtml  = "<div id='item-menu-"+itemObj.id+"' class='item-menu item-menu-hijo' >";
        itemHtml +=     "<span>"+itemObj.order+" |</span>";
        itemHtml +=     "<span>"+itemObj.name+"</span>   <a onclick='eliminarItem("+itemObj.id+")'><li class='icon-remove'></li></a>";
        itemHtml += "</div>";
        $("#"+idPadre).append(itemHtml);
    }
    function borrarItem(id){
        $("#item-menu-"+id).remove();
    }
    
    function nuevoItemHijo(idPadre){
        $("#item-menu-padre").val(idPadre);
        $("#item-menu-menu-id").val("");
        clearItemMenuForm();
        $("#item-menu-form").dialog({
            modal: "true"
        });
    }
    
    function clearItemMenuForm(){
        $("#item-menu-nombre").val("");
        $("#item-menu-seccion").val("");
        orden: $("#item-menu-orden").val("");
    }
    
    $(document).ready(function(){
        $(".sortable").sortable();
        $( ".sortable" ).disableSelection();
    });
    
</script>
<style>
    .item-menu{
        border: 1px solid darkgray;
        padding: 5px;
        width: 600px;
        margin: 5px;
        background-color: white;
        border-radius: 3px;
    }
    .item-menu span{
        /*        font-weight: bold;*/
    }
    .item-menu a{
        float: right;
        cursor: pointer;
        margin-right: 10px;
    }
    .item-menu-hijo{
        width: 500px;
        margin-left: 10px;
        background-color: #B8E834;
    }
</style>
<div class="page-header">
    <h1>Menu
        <small>Editar</small>
    </h1>
</div>
<form action="<?php echo "/adminMenu/save" ?>" method="post" id="menuForm">
    <input type="hidden" name="id" id="menu-id" value="<?php echo $viewData['menu']->getId() ?>" />
    <div>
        <label>Nombre</label>
        <input type="text" name="name" value="<?php echo $viewData['menu']->getName() ?>"/>
    </div>
    <div class="well">
        <h4>Items</h4>
        <div id="items" class="sortable">
            <?php foreach ($viewData['items'] as $item): ?>
                <div class="item-menu" id='<?php echo "item-menu-" . $item->getId() ?>'>
                    <span><i class="icon-move"></i></span>
                    <span><?php echo $item->getName() ?></span>
                    <a onclick='eliminarItem(<?php echo $item->getId() ?>)'><li class="icon-remove"></li></a>
                    <a onclick='nuevoItemHijo(<?php echo $item->getId() ?>)'><li class='icon-plus'></li></a>
                    <a onclick='editarItem(<?php echo $item->getId() ?>)'><li class='icon-edit'></li></a>
                    <div class="sortable">
                        <?php foreach ($item->getSubItems() as $subitem): ?>
                            <div class="item-menu item-menu-hijo" id='<?php echo "item-menu-" . $subitem->getId() ?>'>
                                <span><i class="icon-move"></i></span>
                                <span><?php echo $subitem->getName() ?></span>
                                <a onclick='eliminarItem(<?php echo $subitem->getId() ?>)'><li class="icon-remove"></li></a>
                                <a onclick='editarItemHijo(<?php echo $subitem->getId() ?>)'><li class="icon-edit"></li></a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <a class="btn" onclick="nuevoItem();"><li class='icon-plus-sign'></li>nuevo item</a>
    </div>
    <br/>
    <div class="form-actions">
        <button type="button" onclick="doGuardar();" class="btn btn-primary btn-large">Guardar</button>
        <a href="/adminMenu/index" class="btn btn-large">Cancelar</a>
    </div>
</form>

<div id="item-menu-form" style="display: none;">
    <input type="hidden" id="item-menu-padre" value="" />
    <input type="hidden" id="item-menu-menu-id" value="" />
    <div>
        <label>Nombre</label>
        <input type="text" id="item-menu-nombre" />
    </div>
    <div>
        <label>Página</label>
        <select id="item-menu-seccion">
            <option value="">Elija la pagina...</option>
            <?php foreach ($viewData['pages'] as $page): ?>
                <option value="<?php echo $page->getId(); ?>"><?php echo $page->getName(); ?></option>
            <?php endforeach; ?>
        </select>
        <label>Link</label>
        <input type="text" id="item-menu-link" placeholder="Url del link..." />
        <label>Target</label>
        <select name="target" id="item-menu-linktarget">
            <optgroup>
                <option value="_blank">new tab</option>
                <option value="">same tab</option>
            </optgroup>
        </select>
    </div>
    <div>
        <label>Orden</label>
        <input type="text" id="item-menu-orden" value="1" />
    </div>
    <br/>
    <a class="btn btn-primary" onclick="guardarItem();" >Guardar</a>
    <a class="btn" onclick="cerrarNuevoItem();">Cancelar</a>
</div>