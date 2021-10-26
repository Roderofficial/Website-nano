$("#remove_logs").submit(function (event) {
    event.preventDefault();
    var form = document.querySelector('form');
    var radios = document.getElementsByName("remove_logs_enable");
    if(radios[0].checked == true){
        if ($("#remove_logs_channel").val() == ''){
            toastr.info('Musisz wybrać kanał!');
        }else{
            request_manager('#remove_logs', 'submit_remove.php')
        }

    }else{
        request_manager('#remove_logs','submit_remove.php')
    }
});

$("#edit_logs").submit(function (event) {
    event.preventDefault();
    var form = document.querySelector('form');
    var radios = document.getElementsByName("edit_logs_enable");
    if (radios[0].checked == true) {
        if ($("#leave_channel").val() == '') {
            toastr.info('Musisz wybrać kanał!');
        } else {
            request_manager('#edit_logs', 'submit_edit.php')
        }

    } else {
        request_manager('#edit_logs', 'submit_edit.php')
    }
});


//Edit logs