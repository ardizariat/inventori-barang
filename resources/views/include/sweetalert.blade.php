<script src="{{ asset('admin/js/plugin/sweetalert-2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('admin/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
<script src="{{ asset('admin/js/plugin/notify/bootstrap-notify.js') }}"></script>
{{-- @if (session('success'))
    <script>
        $.notify({
            // options
            icon: 'glyphicon glyphicon-warning-sign',
            title: 'Bootstrap notify',
            message: 'pk',
            url: 'https://github.com/mouse0270/bootstrap-notify',
            target: '_blank'
        }, {
            // settings
            element: 'body',
            position: null,
            type: "info",
            allow_dismiss: true,
            newest_on_top: false,
            showProgressbar: false,
            placement: {
                from: "top",
                align: "right"
            },
            offset: 20,
            spacing: 10,
            z_index: 1031,
            delay: 5000,
            timer: 1000,
            url_target: '_blank',
            mouse_over: null,
            animate: {
                enter: 'animated fadeInDown',
                exit: 'animated fadeOutUp'
            },
            onShow: null,
            onShown: null,
            onClose: null,
            onClosed: null,
            icon_type: 'class',
            template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
                '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
                '<span data-notify="icon"></span> ' +
                '<span data-notify="title">{1}</span> ' +
                '<span data-notify="message">{2}</span>' +
                '<div class="progress" data-notify="progressbar">' +
                '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
                '</div>' +
                '<a href="{3}" target="{4}" data-notify="url"></a>' +
                '</div>'
        });
    </script>
@endif --}}
@if (session('success'))
    <script>
        Swal.fire({
            position: 'center',
            icon: 'success',
            title: '{!! session('success') !!}',
            showConfirmButton: false,
            timer: 2000,
            showClass: {
                popup: 'animate__animated animate__jackInTheBox'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutUp'
            }
        })
    </script>
@endif
