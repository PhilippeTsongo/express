export class IONotification 
{
    success(message){
        setTimeout(function () {
            toastr.options = {
                "positionClass": "toast-top-right",
                "closeButton": true,
                "progressBar": true,
                "showEasing": "swing",
                "timeOut": "6000"
            };
            toastr.success(message);
        }, 50);
    }
    error(message){
        setTimeout(function () {
            toastr.options = {
                "positionClass": "toast-top-right",
                "closeButton": true,
                "progressBar": true,
                "showEasing": "swing",
                "timeOut": "6000"
            };
            toastr.warning(message);
        }, 50);
    }
    info(message){
        setTimeout(function () {
            toastr.options = {
                "positionClass": "toast-top-right",
                "closeButton": true,
                "progressBar": true,
                "showEasing": "swing",
                "timeOut": "60000"
            };
            toastr.info(message);
        }, 50);
    }
}