<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/app.css')
    <title>Order Food</title>
</head>

<body>
    @include('layouts.navbar')
    @include('layouts.header')

    @yield('content')

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @vite('resources/js/app.js')

    <script>
        // show flash messages with SweetAlert if present
        (function(){
            const success = @json(session('success'));
            const error = @json(session('error'));
            if (success) {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: success,
                    showConfirmButton: false,
                    timer: 3000
                });
            }
            if (error) {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: error,
                    showConfirmButton: false,
                    timer: 4000
                });
            }
        })();
    </script>
    @yield('scripts')
</body>

</html>
