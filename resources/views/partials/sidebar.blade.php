<!-- resources/views/partials/sidebar.blade.php -->
<div class="col-md-3 col-lg-2 sidebar text-white p-0">
    <div class="p-4">
        <div class="d-flex align-items-center mb-4">
            <div class="user-avatar me-3">
                <i class="bi bi-shield-check"></i>
            </div>
            <div>
                <h4 class="mb-0">Admin Panel</h4>
                <small class="mb-0">Control Total</small>
            </div>
        </div>

        <nav class="nav flex-column">

             <a class="nav-link text-white sidebar-link p-3 active" href="{{ route('admin') }}">
                <i class="bi bi-people me-2"></i> Usuarios
            </a>
            <a class="nav-link text-white sidebar-link p-3" href="#dashboard">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
           
            <a class="nav-link text-white sidebar-link p-3" href="#settings">
                <i class="bi bi-gear me-2"></i> Configuración
            </a>
            <a class="nav-link text-white sidebar-link p-3" href="#reports">
                <i class="bi bi-graph-up me-2"></i> Reportes
            </a>
            <a class="nav-link text-white sidebar-link p-3" href="{{ route('analytics') }}">
                <i class="bi bi-bar-chart me-2"></i> Analytics
            </a>
        </nav>
    </div>

    <div class="mt-auto p-4">
        <div class="d-flex align-items-center">
            <div class="user-avatar me-3">
                <i class="bi bi-person"></i>
            </div>
            <div>
                <div class="fw-semibold">Administrador</div>
                <small class="text-muted">admin@sistema.com</small>
            </div>
        </div>
        <hr class="my-3 opacity-25">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-box-arrow-right me-2"></i> Cerrar Sesión
            </button>
        </form>
    </div>
</div>
