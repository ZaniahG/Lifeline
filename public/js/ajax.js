$(document).ready(function () {
    $(document).delegate(".form", "submit", function (e) {
        submit(e, this);
    });
});

function submit(e, obj) {
    e.preventDefault();
    //this used to disable element[mostly buttons] until process is done.
    var submit = $(obj).find(":submit");
    var action = $(obj).find('input[name="action"]').val();
    console.log('action =>', action);
    $(submit).attr("disabled", true);

    var formData = new FormData(obj);
    var width = $(submit).css("width");
    var buttonText = $(submit).html();
    $(submit).css("width", width);
    $(submit).html('<i class="fas fa-circle-notch fa-spin"></i>');

    ajax = new XMLHttpRequest();
    ajax.onreadystatechange = function () {
        if (ajax.status) {
            if (ajax.status == 200 && ajax.readyState == 4) {
                //To do tasks if any, when upload is completed
                try {
                    var data = JSON.parse(this.responseText);
                    console.log(data);

                    if (data.code == 200) {
                        switch (action) {
                            default:
                                Snackbar.show({
                                    text: data.msg,
                                    pos: 'top-right',
                                    showAction: false,
                                    actionText: "Dismiss",
                                    duration: 1500,
                                    textColor: '#fff',
                                    backgroundColor: '#5cb85c',
                                    onClose: function () {
                                        if (data.redirect) {
                                            location.replace(data.redirect);
                                        }
                                    }
                                });

                        }

                    } else {
                        switch (action) {
                            default:
                                Snackbar.show({
                                    text: data.msg,
                                    pos: 'top-right',
                                    showAction: false,
                                    actionText: "Dismiss",
                                    duration: 1500,
                                    textColor: '#fff',
                                    backgroundColor: '#ed5c5c',
                                    onClose: function () {
                                        console.log('closing');
                                        if (data.redirect) {
                                            location.replace(data.redirect);
                                        }
                                    }
                                });
                        }
                    }



                } catch (error) {
                    console.log(error);

                }
                $(submit).attr("disabled", false);
                $(submit).html(buttonText);
            }
        }
    };
    ajax.open("POST", action, true);
    ajax.send(formData);
}