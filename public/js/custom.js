function showToast(msg, type = 'success', pos = 'top-right') {

    var textColor = '#fff';
    var backgroundColor = '#5cb85c';
    if (type == "error") {
        textColor = '#fff';
        backgroundColor = '#635BFF';
    }

    Snackbar.show({
        text: msg,
        pos: pos,
        showAction: false,
        actionText: "Dismiss",
        duration: 1500,
        textColor: textColor,
        backgroundColor: backgroundColor,
        // onClose: function () {
        //     if (data.redirect) {
        //         location.replace(data.redirect);
        //     }
        // }
    });
}

$(document).on('click', 'a[data-ajax-popup="true"], button[data-ajax-popup="true"], div[data-ajax-popup="true"]', function () {
    var title = $(this).data('title');
    var size = ($(this).data('size') == '') ? 'md' : $(this).data('size');
    var url = $(this).data('url');
    $("#commonModal .modal-title").html(title);
    $("#commonModal .modal-dialog").addClass('modal-' + size);
    $.ajax({
        url: url,
        success: function (data) {
            // console.log(data);
            $('#commonModal .modal-body').html(data);
            $("#commonModal").modal('show');
        },
        error: function (data) {
            data = data.responseJSON;
        }
    });

});