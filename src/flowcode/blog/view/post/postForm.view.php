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

    function changeType() {
        var selected = $('#type').val();
        switch (selected) {
            case 'd':
                $('#intro-container').show();
                break;
            case 'i':
                $('#intro-container').hide();
                break;
        }
    }

    CKEDITOR.on('instanceCreated', function(event) {
        var editor = event.editor, element = editor.element;
        editor.on('configLoaded', function() {
            editor.config.removePlugins = 'colorbutton,find,flash,newpage,removeformat,smiley,specialchar,templates, forms, scayt, save, preview, print, pagebreak';
            editor.config.toolbarGroups = [
                {name: 'clipboard', groups: ['clipboard', 'undo']},
                {name: 'links'},
                {name: 'insert'},
                {name: 'tools'},
                {name: 'document', groups: ['mode']},
                {name: 'basicstyles', groups: ['basicstyles', 'cleanup']},
                '/',
                {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi']},
                {name: 'styles'},
                {name: 'colors'}
            ];
        });
    });

    $(document).ready(function() {
        CKEDITOR.replace('sbody', {width: "800"});
        CKEDITOR.replace('intro');
        changeType();
        $("#datepicker").datetimepicker({dateFormat: 'yy-mm-dd'});
    });


</script>

<form action="/adminBlog/savePost" method="post" class="form">
    <?php if ($viewData['post']->getId() != NULL): ?>
        <input type="hidden" name="id" value="<?php echo $viewData['post']->getId() ?>" />
        <input type="hidden" name="permalink" value="<?php echo $viewData['post']->getPermalink() ?>" />
    <?php endif; ?>
    <div class="row-fluid">
        <div class="control-group span8">
            <div class="controls">
                <input type="text" id="title" placeholder="Título del post" name="title" class="input-xxlarge" value="<?php echo $viewData['post']->getTitle() ?>">
            </div>
        </div>
        <div class="control-group span4">
            <div class="controls">
                <select name="type" id="type" onchange="changeType()">
                    <option <?php
                    if ($viewData['post']->getType() == 'i') {
                        echo "selected='selected'";
                    }
                    ?>value="i">Post corto</option>
                    <option <?php
                    if ($viewData['post']->getType() == 'd') {
                        echo "selected='selected'";
                    }
                    ?> value="d">Post Largo</option>
                </select>
            </div>
        </div>
    </div>

    <div class="control-group" style="display:none;" id="intro-container">
        <label class="control-label">Intro</label>
        <div class="controls">
            <textarea id="intro" class="ckeditor" name="intro"><?php echo $viewData['post']->getIntro() ?></textarea>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label">Cuerpo</label>
        <div class="controls">
            <textarea id="sbody" name="body" class="ckeditor" placeholder="Cuerpo del post" ><?php echo $viewData['post']->getBody() ?></textarea>
        </div>
    </div>


    <div class="row-fluid">
        <div class="span6 form-horizontal">
            <div class="control-group">
                <label class="control-label">Peque&ntilde;a descripci&oacute;n (opcional)</label>
                <div class="controls">
                    <textarea name="description"><?php echo $viewData['post']->getDescription() ?></textarea>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Fecha</label>
                <div class="controls">
                    <input type="text" id="datepicker" name="fecha" value="<?php echo $viewData['post']->getDate() ?>" />
                </div>
            </div>
        </div>


        <div class="span6 form-horizontal">
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
    </div>

</form>