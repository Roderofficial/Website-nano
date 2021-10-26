function request_manager(form_id, request_address){
    var formElement = document.querySelector(form_id);
    var request = new XMLHttpRequest();
    var submit_button = formElement.querySelector('button[type="submit"]');
    var submit_before = submit_button.innerHTML;
    console.log(submit_button)
    //DISABLE BUTTON AND ADD SPINNER
    submit_button.disabled = true;

    submit_button.innerHTML = '<span id="spinerbutton" class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="margin-right: 5px; "></span> ' + submit_button.innerHTML;
    request.open("POST", request_address, true);submit_button.innerHTML
    request.onload = function (e) {
        if (request.readyState === 4) {
            if (request.status == 200) {
                toastr.success('Success!')
            } else if (request.status == 401) {
                toastr.error('Zaloguj się ponownie', 'Error! Session timeout. Log in and try again.');

            } else {
                toastr.error(request.statusText, 'Błąd: ' + request.status,);
                console.log(request);
            }

        }
        //ENABLE BUTTON AND ADD SPINNER
        submit_button.disabled = false;
        submit_button.innerHTML = submit_before;
    }
    request.send(new FormData(formElement));



}