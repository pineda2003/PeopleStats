<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Usuarios</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">

    
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar text-white p-0">
                <div class="p-4">
                    <div class="d-flex align-items-center mb-4">
                        <i class="bi bi-shield-check fs-3 me-2"></i>
                        <h4 class="mb-0">Admin Panel</h4>
                    </div>
                    
                    <nav class="nav flex-column">
                        <a class="nav-link text-white sidebar-link p-3 mb-2" href="#dashboard">
                            <i class="bi bi-speedometer2 me-2"></i>
                            Dashboard
                        </a>
                        <a class="nav-link text-white sidebar-link p-3 mb-2 bg-white bg-opacity-25" href="#users">
                            <i class="bi bi-people me-2"></i>
                            Usuarios
                        </a>
                        <a class="nav-link text-white sidebar-link p-3 mb-2" href="#settings">
                            <i class="bi bi-gear me-2"></i>
                            Configuración
                        </a>
                        <a class="nav-link text-white sidebar-link p-3 mb-2" href="#reports">
                            <i class="bi bi-graph-up me-2"></i>
                            Reportes
                        </a>
                    </nav>
                </div>
                
                <div class="mt-auto p-4">
                    <div class="d-flex align-items-center">
                        <div class="user-avatar me-2">
                            <i class="bi bi-person"></i>
                        </div>
                        <div>
                            <small class="d-block">Administrador</small>
                            <small class="text-white-50">admin@ejemplo.com</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 main-content">
                <div class="p-4">
                    <!-- Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h2 class="mb-1">Gestión de Usuarios</h2>
                            <p class="text-muted mb-0">Administra todos los usuarios del sistema</p>
                        </div>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                            <i class="bi bi-plus-circle me-2"></i>
                            Nuevo Usuario
                        </button>
                    </div>

                    <!-- Stats Cards -->
                    <div class="row mb-4">
                        <div class="col-md-3 mb-3">
                            <div class="card stats-card">
                                <div class="card-body text-center">
                                    <i class="bi bi-people fs-1 mb-2"></i>
                                    <h3 class="mb-0">1,234</h3>
                                    <small>Total Usuarios</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card stats-card">
                                <div class="card-body text-center">
                                    <i class="bi bi-person-check fs-1 mb-2"></i>
                                    <h3 class="mb-0">956</h3>
                                    <small>Usuarios Activos</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card stats-card">
                                <div class="card-body text-center">
                                    <i class="bi bi-person-plus fs-1 mb-2"></i>
                                    <h3 class="mb-0">42</h3>
                                    <small>Nuevos Hoy</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card stats-card">
                                <div class="card-body text-center">
                                    <i class="bi bi-person-x fs-1 mb-2"></i>
                                    <h3 class="mb-0">15</h3>
                                    <small>Inactivos</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filters and Search -->
                    <div class="table-container">
                        <div class="p-3 border-bottom">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-search"></i>
                                        </span>
                                        <input type="text" class="form-control" placeholder="Buscar usuarios..." id="searchInput">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-select" id="statusFilter">
                                        <option value="">Todos los estados</option>
                                        <option value="active">Activos</option>
                                        <option value="inactive">Inactivos</option>
                                        <option value="pending">Pendientes</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-select" id="roleFilter">
                                        <option value="">Todos los roles</option>
                                        <option value="admin">Administrador</option>
                                        <option value="user">Usuario</option>
                                        <option value="moderator">Moderador</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Users Table -->
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>
                                            <input type="checkbox" class="form-check-input" id="selectAll">
                                        </th>
                                        <th>Usuario</th>
                                        <th>Email</th>
                                        <th>Rol</th>
                                        <th>Estado</th>
                                        <th>Registro</th>
                                        <th>Último Acceso</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="usersTable">
                                    <!-- Datos de ejemplo -->
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="form-check-input user-checkbox">
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="user-avatar me-3">JD</div>
                                                <div>
                                                    <div class="fw-semibold">Juan Díaz</div>
                                                    <small class="text-muted">ID: 1</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>juan.diaz@ejemplo.com</td>
                                        <td><span class="badge bg-primary">Admin</span></td>
                                        <td><span class="badge bg-success">Activo</span></td>
                                        <td>15/03/2024</td>
                                        <td>Hace 2 horas</td>
                                        <td>
                                            <button class="action-btn btn-view" title="Ver detalles">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button class="action-btn btn-edit" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="action-btn btn-delete" title="Eliminar">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="form-check-input user-checkbox">
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="user-avatar me-3">MG</div>
                                                <div>
                                                    <div class="fw-semibold">María García</div>
                                                    <small class="text-muted">ID: 2</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>maria.garcia@ejemplo.com</td>
                                        <td><span class="badge bg-secondary">Usuario</span></td>
                                        <td><span class="badge bg-success">Activo</span></td>
                                        <td>12/03/2024</td>
                                        <td>Ayer</td>
                                        <td>
                                            <button class="action-btn btn-view" title="Ver detalles">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button class="action-btn btn-edit" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="action-btn btn-delete" title="Eliminar">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="form-check-input user-checkbox">
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="user-avatar me-3">CL</div>
                                                <div>
                                                    <div class="fw-semibold">Carlos López</div>
                                                    <small class="text-muted">ID: 3</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>carlos.lopez@ejemplo.com</td>
                                        <td><span class="badge bg-info">Moderador</span></td>
                                        <td><span class="badge bg-warning">Pendiente</span></td>
                                        <td>10/03/2024</td>
                                        <td>Hace 3 días</td>
                                        <td>
                                            <button class="action-btn btn-view" title="Ver detalles">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button class="action-btn btn-edit" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="action-btn btn-delete" title="Eliminar">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="p-3 border-top">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <small class="text-muted">Mostrando 1-10 de 1,234 usuarios</small>
                                </div>
                                <div class="col-md-6">
                                    <nav>
                                        <ul class="pagination pagination-sm justify-content-end mb-0">
                                            <li class="page-item disabled">
                                                <span class="page-link">Anterior</span>
                                            </li>
                                            <li class="page-item active">
                                                <span class="page-link">1</span>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link" href="#">2</a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link" href="#">3</a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link" href="#">Siguiente</a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Agregar Usuario -->
    <div class="modal fade" id="addUserModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-person-plus me-2"></i>
                        Agregar Nuevo Usuario
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addUserForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nombre Completo</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Contraseña</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Confirmar Contraseña</label>
                                <input type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Rol</label>
                                <select class="form-select" name="role" required>
                                    <option value="">Seleccionar rol</option>
                                    <option value="admin">Administrador</option>
                                    <option value="moderator">Moderador</option>
                                    <option value="user">Usuario</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Estado</label>
                                <select class="form-select" name="status" required>
                                    <option value="active">Activo</option>
                                    <option value="inactive">Inactivo</option>
                                    <option value="pending">Pendiente</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" form="addUserForm">
                        <i class="bi bi-check-circle me-2"></i>
                        Crear Usuario
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    
  
</body>
</html>