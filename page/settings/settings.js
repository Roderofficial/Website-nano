$("#settings").submit(function (event) {
    event.preventDefault();
    var form = document.querySelector('form');
    if (form.checkValidity()) {
        var formElement = document.querySelector("form");
        var request = new XMLHttpRequest();
        request.open("POST", "submit.php",false);
        request.send(new FormData(formElement));
        if (request.status == 200){
            toastr.success('Sukces!')
        }else{
            toastr.error('Błąd' + toString(request.status))
        }
            


    } 
});