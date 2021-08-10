{{-- <script src="{{ asset('admin/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
<script src="{{ asset('admin/js/plugin/notify/bootstrap-notify.js') }}"></script> --}}
<script src="{{ asset('admin/js/plugin/sweetalert-2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('admin/js/plugin/izitoast/js/iziToast.min.js') }}"></script>
<script>
    function alert_success(type, message) {
        iziToast.success({
            theme: 'light',
            position: 'topRight',
            icon: 'fas fa-check',
            title: 'Berhasil',
            message: message,
            // progressBarColor: 'rgb(0, 255, 184)',
            progressBarColor: '#000',
            layout: 1,
        });
    }

    function alert_error(type, message) {
        Swal.fire('Oops...', message, type);
    }
</script>
