<script src="{{ asset('admin/js/plugin/sweetalert-2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('admin/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
<script src="{{ asset('admin/js/plugin/notify/bootstrap-notify.js') }}"></script>
@if (session('success'))
    <script>
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
    </script>
@endif
