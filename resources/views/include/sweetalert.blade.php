<script src="{{ asset('admin/js/plugin/sweetalert-2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('admin/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
<script src="{{ asset('admin/js/plugin/notify/bootstrap-notify.js') }}"></script>
<script>
    @if (session('success'))
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'ok',
            showConfirmButton: false,
            timer: 1500,
            showClass: {
                popup: 'animate__animated animate__rubberBand'
            },
            hideClass: {
                popup: 'animate__animated animate__zoomOutUp'
            }
        })
    @endif

    function alert_success(type, message){
      Swal.fire({
        position: 'top-end',
        icon: type,
        title: message,
        showConfirmButton: false,
        timer: 2000,
        showClass: {
            popup: 'animate__animated animate__lightSpeedInRight'
        },
        hideClass: {
            popup: 'animate__animated animate__lightSpeedOutRight'
        }
      })
    }

    function alert_error(type, message){
        Swal.fire('Oops...', message, type);
    }
</script>
