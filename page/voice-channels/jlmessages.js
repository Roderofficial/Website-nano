$("#join_messages").submit(function (event) {
    event.preventDefault();
    var form = document.querySelector('form');
    var radios = document.getElementsByName("join_enable");
    if(radios[0].checked == true){
        if ($("#join_channel").val() == ''){
            toastr.info('Musisz wybrać kanał!');
        }else{
            request_manager('#join_messages', 'submit_join.php')
        }

    }else{
        request_manager('#join_messages','submit_join.php')
    }
});

$("#leave_messages").submit(function (event) {
    event.preventDefault();
    var form = document.querySelector('form');
    var radios = document.getElementsByName("leave_enable");
    if (radios[0].checked == true) {
        if ($("#leave_channel").val() == '') {
            toastr.info('Musisz wybrać kanał!');
        } else {
            request_manager('#leave_messages', 'submit_leave.php')
        }

    } else {
        request_manager('#leave_messages', 'submit_leave.php')
    }
});