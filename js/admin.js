$(document).ready(function() {
    $('.dropdown-toggle').dropdown();
    $('#main-menu-fix').affix();
    $('.tooltipx').tooltip()
    $(window).flowhistory();
});

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
            $("#modal-save").click(function() {
                saveEntity(urlAction);
                $('#dialog').modal('hide')
                $.fn.flowhistory()
            });
            $("#dialog").modal();
        }
    });
}

function saveEntity(url) {
    $.ajax({
        url: url,
        type: "post",
        data: $(".form").serialize(),
        success: function(data) {
            sayToUser("success", "Se guardo correctamente.");
        },
        error: function(data) {
            sayToUser("error", "Hubo un error.");
        }
    });
}
function updateEntity(text, urlForm, urlAction) {
    $.ajax({
        url: urlForm,
        type: "html",
        success: function(data) {
            $("#dialog > .modal-body").html(data);
            $("#dialog h3").html(text);
            $("#modal-save").click(function() {
                saveEntity(urlAction);
                $('#dialog').modal('hide')
                $.fn.flowhistory()
            });
            $("#dialog").modal();
        }
    });
}
function deleteEntity(urlAction) {
    $.ajax({
        url: urlAction,
        type: "post",
        success: function(data) {
            sayToUser("success", "Se borro correctamente");
            $.fn.flowhistory();
        }
    });
}