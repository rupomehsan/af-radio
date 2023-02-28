var rootUrl = window.origin + "/api/v1/"
var baseUrl = window.origin


function formSubmit(method, url, form, buttonId = null, headers = null) {
    let form_data = JSON.stringify(form.serializeJSON());
    let formData = JSON.parse(form_data);
    $('#preloader').removeClass('d-none')
    $.ajax({
        method: method,
        url: url,
        data: formData,
        beforeSend: function () {
            $('#' + buttonId).prop('disabled', true);
        },
        success: function (response) {
            if (response.status === 'success') {
                toastr.success(response.message)
                setTimeout(reload, 1000)
                function reload() {
                    location.reload()
                }
            } else if (response.status == "error") {
                toastr.error(response.message)
            }
        },
        error: function (xhr, resp, text) {
            if (xhr && xhr.responseText) {
                // $('#preloader').addClass('d-none')
                let response = JSON.parse(xhr.responseText);
                console.log("response",response)
                if (response.status === 'validate_error') {
                    $('#preloader').addClass('d-none')
                    $(".fa-spin").removeClass('fa-spinner')
                    $.each(response.data, function (index, message) {
                        if (message.field && message.field !== 'global') {
                            $('#' + message.field + '_error').html(message.error);
                        } else if (message.error) {
                            // toastr.error(message.error);
                            console.log("err 0")
                        } else {
                            // toastr.error('Something went wrong', 'Please try again after sometime.');
                            console.log("err 1")
                        }
                    });
                } else if (response.status === 'error') {
                    toastr.error(response.message);
                    console.log("err 2")
                }else if (response.status === 'server_error') {
                    if(response.message==='Attempt to read property \"api_key\" on null'){
                        toastr.error("Please make sure your notification settings for sending notification");
                    }else{
                        toastr.error(response.message);
                    }


                }
            }
        },
        complete: function (xhr, status) {
            $('#' + buttonId).prop('disabled', false);
            $('#preloader').addClass('d-none')
        }
    });

}
