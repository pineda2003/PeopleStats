<!-- resources/views/layouts/admin.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('tituloPage', 'Panel de Administración')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('dist/css/adminEstilos/admin.css') }}">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            
            {{-- Sidebar --}}
            @include('partials.sidebar')

            {{-- Contenido principal --}}
            <div class="col-md-9 col-lg-10 main-content">
                <div class="p-4">
                    @yield('contenido')
                </div>
            </div>
        </div>
    </div>

    {{-- Scripts --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('dist/js/adminJs/admin.js') }}"></script>
</body>
</html>
