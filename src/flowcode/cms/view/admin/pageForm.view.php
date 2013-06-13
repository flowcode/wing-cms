<script type="text/javascript" src="/js/ckeditor/ckeditor.js"></script>
<script>

    $(document).ready(function() {

        $('#tabs a').click(function(e) {
            e.preventDefault();
            $(this).tab('show');
        });

        CKEDITOR.editorConfig = function(config) {
            config.language = 'es'
        };

        CKEDITOR.replace('htmlContent', {width: 700});
        elegirContenido();
    });

    function elegirContenido() {
        var tipo = $("#tipo").val();
        $(".contenido").hide();
        switch (tipo) {
            case "100":
                $("#contenido-simple").show();
                break;
            case "110":
                $("#contenido-estatico").show();
                break;
            default:
                $("#contenido-simple").show();
                break;
        }
    }
</script>

<style>
    .slot-img{
        float: left;
        height: 120px;
        width: 120px;
        border: 1px #666 dotted;
    }
</style>

<form action="<?php echo "/adminPage/save" ?>" method="post">
    <input type="hidden" name="id"          value="<?php echo $viewData['page']->getId() ?>" />
    <input type="hidden" name="permalink"   value="<?php echo $viewData['page']->getPermalink() ?>" />

    <ul class="nav nav-tabs" id="tabs">
        <li class="active"><a href="#datos-basicos-tab" data-toggle="tab"><h5>Datos b&aacute;sicos</h5></a></li>
        <li><a href="#contenido-tab" data-toggle="tab"><h5>Contenido</h5></a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="datos-basicos-tab">
            <div>
                <label>Nombre</label>
                <input type="text" name="name" value="<? echo $viewData['page']->getName() ?>"/>
            </div>
            <div>
                <label>Descripcion</label>
                <textarea id="descripcion" name="description"><? echo $viewData['page']->getDescription() ?></textarea>
            </div>
            <div>
                <label>Estado</label>
                <select id="estado" name="status">
                    <?php if ($viewData['page']->getStatus() == '0'): ?>
                        <option selected="true" value="0">Borrador</option>
                        <option value="1">Publicada</option>
                    <?php endif; ?>
                    <?php if ($viewData['page']->getStatus() == '1'): ?>
                        <option value="0">Borrador</option>
                        <option selected="true" value="1">Publicada</option>
                    <?php else: ?>
                        <option value="1">Publicada</option>
                        <option value="0">Borrador</option>
                    <?php endif; ?>
                </select>
            </div>

        </div>
        <div class="tab-pane" id="contenido-tab">
            <div>
                <select id="tipo" name="type" onchange="elegirContenido()">
                    <option value="100"<?php echo ($viewData['page']->getType() == "100") ? "selected" : ""; ?>>Página plana</option>
                    <option value="110"<?php echo ($viewData['page']->getType() == "110") ? "selected" : ""; ?>>Custom</option>
                </select>
            </div>
            <div id="contenido-simple" class="contenido">
                <label>Contenido</label>
                <textarea id="contenido" name="htmlContent" id="htmlContent" style="width: 600px; height: 300px;"><?php echo $viewData['page']->getHtmlContent() ?></textarea>
            </div>
            <div id="contenido-estatico" class="contenido" style="display: none;">
                <span class="label label-important">El tipo de seccion que eligio es propia del sistema, y su contenido se administra accediendo desde el menu.</span>
            </div>
        </div>
    </div>
</form>
