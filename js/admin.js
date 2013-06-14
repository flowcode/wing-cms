
function sayToUser(level, message) {
    switch (level) {
        case 'success':
            $().toastmessage('showSuccessToast', message);
            break;
        case 'warning':
            $().toastmessage('showWarningToast', message);
            break;
        case 'error':
            $().toastmessage('showErrorToast', message);
            break;
        case 'notice':
            $().toastmessage('showNoticeToast', message);
            break;

        default:
            $().toastmessage('showNoticeToast', message);
            break;
    }
}

function createEntity(text, urlForm, urlAction) {
    $.ajax({
        url: urlForm,
        type: "html",
        success: function(data) {
            $("#dialog > .modal-body").html(data);
            $("#dialog h3").html(text);
            $("#modal-save").one('click', function() {
                $(".ckeditor").each(function() {
                    var id = $(this).attr("id");
                    CKEDITOR.instances[id].updateElement();
                });
                saveEntity(urlAction);
                $('#dialog').modal('hide')
                $.fn.flowhistory()
            });
            $("#dialog").modal();
        }
    });
}

function saveEntity(url) {
    if (url.length > 0) {
        $.ajax({
            url: url,
            type: "post",
            data: $(".form").serialize(),
            success: function(data) {
                if (data == "success") {
                    sayToUser("success", "Se guardo correctamente.");
                    $("#dialog > .modal-body").empty();
                } else {
                    sayToUser("error", "Hubo un error en la operación");
                }
            },
            error: function(data) {
                sayToUser("error", "Hubo un error en la operación");
            }
        });
    }
}
function updateEntity(text, urlForm, urlAction) {
    $.ajax({
        url: urlForm,
        type: "html",
        success: function(data) {
            $("#dialog > .modal-body").html(data);
            $("#dialog h3").html(text);
            $("#modal-save").one('click', function() {
                $(".ckeditor").each(function() {
                    var id = $(this).attr("id");
                    CKEDITOR.instances[id].updateElement();
                });
                saveEntity(urlAction);
                $('#dialog').modal('hide')
                $.fn.flowhistory()
            });
            $("#dialog").modal();
        },
        error: function(data) {
            sayToUser("error", "Hubo un error en la operación");
        }
    });
}
function deleteEntity(urlAction) {
    $.ajax({
        url: urlAction,
        type: "post",
        success: function(data) {
            if (data == "success") {
                $.fn.flowhistory();
                sayToUser("success", "Se borro correctamente");
            } else {
                sayToUser("error", "Hubo un error en la operación");
            }
        },
        error: function(data) {
            sayToUser("error", "Hubo un error en la operación");
        }
    });
}

$(document).ready(function() {
    $('.dropdown-toggle').dropdown();
    $('#main-menu-fix').affix();
    $('.tooltipx').tooltip()
    $(window).flowhistory();
});
