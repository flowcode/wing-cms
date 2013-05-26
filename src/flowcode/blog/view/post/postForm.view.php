<link href="/css/blog.css" rel="stylesheet" type="text/css" />
<link href="/css/icrop.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
    function openKCFinder_singleFile() {
        window.KCFinder = {};
        window.KCFinder.callBack = function(url) {
            SetFileField(url);
            window.KCFinder = null;
        };
        window.open('/src/kcfinder/browse.php', 'Admin', 'height=500,width=600');
    }

    function SetFileField(fileUrl) {
        document.getElementById('image_slot_uri').value = fileUrl;
        cambiarImageSlot();
    }

    function cambiarImageSlot() {
        var selectedImg = $('#image_slot_uri').val();
        var bgImg = "url('" + selectedImg + "')";
        $('.crop-img').css('background-image', bgImg);
    }

    function cambiarTipoSlot() {
        var selected = $('#image_slot_tipo').val();
        $('.slotPreview').hide();
        switch (selected) {
            case 'k':
                $('#intro-container').show();
                break;
            case 's':
                $('#intro-container').hide();
                break;
            case 'd':
                $('#intro-container').show();

                break;
            case 'i':
                $('#intro-container').show();
                $('#imageUpload').show();
                break;
        }
        //cambiarImageSlot();
    }

    $(document).ready(function() {
        CKEDITOR.replace('copete', {toolbar: 'basic'});
        CKEDITOR.replace('sbody');
        cambiarTipoSlot();
        $("#datepicker").datetimepicker({dateFormat: 'yy-mm-dd'});
    });

</script>

<form action="/adminBlog/savePost" method="post" class="form">
    <?php if ($viewData['post']->getId() != NULL): ?>
        <input type="hidden" name="id" value="<?php echo $viewData['post']->getId() ?>" />
        <input type="hidden" name="permalink" value="<?php echo $viewData['post']->getPermalink() ?>" />
    <?php endif; ?>
    <div class="row-fluid">
        <div class="span6">

            <div class="control-group">
                <label class="control-label">Titulo</label>
                <div class="controls">
                    <input type="text" id="title" name="title" value="<?php echo $viewData['post']->getTitle() ?>">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Tipo de Post</label>
                <div class="controls">
                    <select name="type" id="image_slot_tipo" onchange="cambiarTipoSlot()">
                        <option <?php
                        if ($viewData['post']->getType() == 's') {
                            echo "selected='selected'";
                        }
                        ?> value="s">No Intro + Rich Body</option>
                        <option <?php
                        if ($viewData['post']->getType() == 'k') {
                            echo "selected='selected'";
                        }
                        ?> value="k">Small Intro + Rich Body</option>
                        <option <?php
                        if ($viewData['post']->getType() == 'd') {
                            echo "selected='selected'";
                        }
                        ?> value="d">Rich Intro + Rich Body</option>
                        <option <?php
                        if ($viewData['post']->getType() == 'i') {
                            echo "selected='selected'";
                        }
                        ?>value="i">Image + Rich Intro + Body</option>
                    </select>
                </div>
                <?
                $style = "background-image: url('" . $viewData['post']->getImageSlotUri() . "');";
                $style .= "background-repeat:no-repeat;";
                $style .= "background-position: " . $viewData['post']->getImageSlotLeft() . "px " . $viewData['post']->getImageSlotTop() . "px;";
                $style .= "background-size: " . $viewData['post']->getImageSlotSize() . "%;";
                ?>
                <div class="post slot-default slotPreview">
                    <a class="post-title">T&iacute;tulo Default</a>
                    <span>20/11/11</span>
                    <div> Intro de la noticia </div>
                    <a class="post-read-more">Leer mas</a>
                </div>
                <div class="post slot-image slotPreview" style="display:none;">
                    <div class="crop-img post-img-slot" style="<? echo $style; ?>"></div>
                    <a class="post-title">T&iacute;tulo Image</a>
                    <span>20/11/11</span>
                    <div> Intro de la noticia </div>
                    <a class="post-read-more">Leer mas</a>
                </div>
                <div class="well slot-image slotPreview" id="imageUpload" style="display:none;">
                    <label>Image slot</label>
                    <input type="text" name="image_slot" id="image_slot_uri" value="<?php echo $viewData['post']->getImageSlot() ?>" onchange="cambiarImageSlot();" />
                    <a onclick="openKCFinder_singleFile();" class="btn" ><li class="icon-search"></li> Buscar</a>
                    <div class="control-pos">
                        <span>Left</span>
                        <input type="text" name="bgleft" class="span2" id="bgleft" value="<?php echo $viewData['post']->getImageSlotLeft() ?>">
                        <button type="button" class="btn btn-mini" id="btn-left-plus"><li class="icon-plus"></li></button>
                        <button type="button" class="btn btn-mini" id="btn-left-minus" onclick="minusLeft();"><li class="icon-minus"></li></button>
                    </div>
                    <div class="control-pos">
                        <span>Top</span>
                        <input type="text" name="bgtop" class="span2" id="bgtop" value="<?php echo $viewData['post']->getImageSlotTop() ?>">
                        <button type="button" class="btn btn-mini" id="btn-top-plus"><li class="icon-plus"></li></button>
                        <button type="button" class="btn btn-mini" id="btn-top-minus"><li class="icon-minus"></li></button>
                    </div>
                    <div class="control-pos">
                        <span>Zoom</span>
                        <input type="text" name="bgsize" class="span2" id="bgsize" value="<?php echo $viewData['post']->getImageSlotSize() ?>">
                        <button type="button" class="btn btn-mini" id="btn-bgsize-plus"><li class="icon-plus"></li></button>
                        <button type="button" class="btn btn-mini" id="btn-bgsize-minus"><li class="icon-minus"></li></button>
                    </div>
                </div>
            </div>



        </div>

        <div class="span6">
            <div class="control-group">
                <label class="control-label">Tags</label>
                <div class="controls">
                    <select multiple="multiple" name="tags[]" style="height: 137px;">
                        <?php foreach ($viewData['tags'] as $tag): ?>
                            <?php
                            $checked = "";
                            foreach ($viewData['post']->getTags() as $postTag) {
                                if ($tag->getId() == $postTag->getId()) {
                                    $checked = "selected";
                                    break;
                                }
                            }
                            ?>
                            <option <?php echo $checked; ?> value="<?php echo $tag->getId(); ?>" ><?php echo $tag; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

        </div>

        <div class="control-group">
            <label class="control-label">Fecha</label>
            <div class="controls">
                <input type="text" id="datepicker" name="fecha" value="<?php echo $viewData['post']->getDate() ?>" />
            </div>
        </div>
    </div>

    <div class="control-group" style="display:none;" id="intro-container">
        <label class="control-label">Intro</label>
        <div class="controls">
            <textarea id="copete" name="intro"><?php echo $viewData['post']->getIntro() ?></textarea>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label">Cuerpo</label>
        <div class="controls">
            <textarea id="sbody" name="body" contenteditable="true"><?php echo $viewData['post']->getBody() ?></textarea>
        </div>
    </div>

</form>