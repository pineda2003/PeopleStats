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
        <link rel="stylesheet" href="{{ asset('dist/css/adminEstilos/admin.css') }}">
   
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar text-white p-0">
                <div class="p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="user-avatar me-3">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <div>
                            <h4 class="mb-0">Admin Panel</h4>
                            <small class="text-muted">Control Total</small>
                        </div>
                    </div>
                    
                    <nav class="nav flex-column">
                        <a class="nav-link text-white sidebar-link p-3" href="#dashboard">
                            <i class="bi bi-speedometer2 me-2"></i>
                            Dashboard
                        </a>
                        <a class="nav-link text-white sidebar-link p-3 active" href="#users">
                            <i class="bi bi-people me-2"></i>
                            Usuarios
                        </a>
                        <a class="nav-link text-white sidebar-link p-3" href="#settings">
                            <i class="bi bi-gear me-2"></i>
                            Configuración
                        </a>
                        <a class="nav-link text-white sidebar-link p-3" href="#reports">
                            <i class="bi bi-graph-up me-2"></i>
                            Reportes
                        </a>
                        <a class="nav-link text-white sidebar-link p-3" href="#analytics">
                            <i class="bi bi-bar-chart me-2"></i>
                            Analytics
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
                  
                    <form action="{{route('logout')}}" method="POST" class="logout-form">
                    @csrf 
                   
                    <button type="submit" class="btn btn-primary"> <i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión</button>
                </form>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 main-content">
                <div class="p-4">
                    <!-- Header -->
                    <div class="admin-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h2 class="mb-1">
                                    <i class="bi bi-people me-2"></i>
                                    Gestión de Usuarios
                                </h2>
                                <p class="text-muted mb-0">Administra todos los usuarios del sistema de forma eficiente</p>
                            </div>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                                <i class="bi bi-plus-circle me-2"></i>
                                Nuevo Usuario
                            </button>
                        </div>
                    </div>

                    

                    <!-- Filters and Search -->
                    <div class="table-container">
                        <div class="p-4 border-bottom">
                            <div class="row align-items-center g-3">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0">
                                            <i class="bi bi-search text-muted"></i>
                                        </span>
                                        <input type="text" class="form-control border-start-0" placeholder="Buscar usuarios por nombre o email..." id="searchInput">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-select" id="statusFilter">
                                        <option value="">📊 Todos los estados</option>
                                        <option value="active">✅ Activos</option>
                                        <option value="inactive">❌ Inactivos</option>
                                        <option value="pending">⏳ Pendientes</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-select" id="roleFilter">
                                        <option value="">👥 Todos los roles</option>
                                        <option value="admin">🛡️ Administrador</option>
                                        <option value="user">👤 Usuario</option>
                                        <option value="moderator">⚖️ Moderador</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Users Table -->
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead style="background: linear-gradient(135deg, #F8F9FA 0%, #E9ECEF 100%);">
                                    <tr>
                                        <th class="border-0 py-3">
                                            <input type="checkbox" class="form-check-input" id="selectAll">
                                        </th>
                                        <th class="border-0 py-3 fw-semibold">Usuario</th>
                                        <th class="border-0 py-3 fw-semibold">Email</th>
                                        <th class="border-0 py-3 fw-semibold">Rol</th>
                                        <th class="border-0 py-3 fw-semibold">Registro</th>
                                        <th class="border-0 py-3 fw-semibold">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="usersTable">
                                    <tr class="border-0">
                                        <td class="py-3">
                                            <input type="checkbox" class="form-check-input user-checkbox">
                                        </td>
                                        <td class="py-3">
                                            <div class="d-flex align-items-center">
                                             
                                                <div>
                                                    <div class="fw-semibold">Juan Díaz</div>
                                                    <small class="text-muted">ID: 1</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3">juan.diaz@ejemplo.com</td>
                                        <td class="py-3"><span class="badge" style="background: var(--primary-green);">🛡️ Admin</span></td>
                                        <td class="py-3">15/03/2024</td>
                                       
                                          
                                        </td>
                                        <td class="py-3">
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
                                    <tr class="border-0">
                                        <td class="py-3">
                                            <input type="checkbox" class="form-check-input user-checkbox">
                                        </td>
                                        <td class="py-3">
                                            <div class="d-flex align-items-center">
                                               
                                                <div>
                                                    <div class="fw-semibold">María García</div>
                                                    <small class="text-muted">ID: 2</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3">maria.garcia@ejemplo.com</td>
                                        <td class="py-3"><span class="badge bg-secondary">👤 Usuario</span></td>
                                   
                                        <td class="py-3">12/03/2024</td>
                                   
                                      
                                        </td>
                                        <td class="py-3">
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
                                    <tr class="border-0">
                                        <td class="py-3">
                                            <input type="checkbox" class="form-check-input user-checkbox">
                                        </td>
                                        <td class="py-3">
                                            <div class="d-flex align-items-center">
                                                
                                                <div>
                                                    <div class="fw-semibold">Carlos López</div>
                                                    <small class="text-muted">ID: 3</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3">carlos.lopez@ejemplo.com</td>
                                        <td class="py-3"><span class="badge bg-info">⚖️ Moderador</span></td>
                                    
                                        <td class="py-3">10/03/2024</td>
                                       
                                       
                                        </td>
                                        <td class="py-3">
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
                        <div class="p-4 border-top">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <small class="text-muted">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Mostrando 1-10 de 1,234 usuarios
                                    </small>
                                </div>
                                <div class="col-md-6">
                                    <nav>
                                        <ul class="pagination pagination-sm justify-content-end mb-0">
                                            <li class="page-item disabled">
                                                <span class="page-link">← Anterior</span>
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
                                                <a class="page-link" href="#">Siguiente →</a>
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
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="addUserForm">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-person me-1"></i>
                                    Nombre Completo
                                </label>
                                <input type="text" class="form-control" name="name" placeholder="Ej: Juan Pérez" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-envelope me-1"></i>
                                    Email
                                </label>
                                <input type="email" class="form-control" name="email" placeholder="ejemplo@correo.com" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-lock me-1"></i>
                                    Contraseña
                                </label>
                                <input type="password" class="form-control" name="password" placeholder="••••••••" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-lock-fill me-1"></i>
                                    Confirmar Contraseña
                                </label>
                                <input type="password" class="form-control" name="password_confirmation" placeholder="••••••••" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-shield me-1"></i>
                                    Rol
                                </label>
                                <select class="form-select" name="role" required>
                                    <option value="">Seleccionar rol</option>
                                    <option value="admin">🛡️ Administrador</option>
                                    <option value="moderator">⚖️ Moderador</option>
                                    <option value="user">👤 Usuario</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-toggle-on me-1"></i>
                                    Estado
                                </label>
                                <select class="form-select" name="status" required>
                                    <option value="active">✅ Activo</option>
                                    <option value="inactive">❌ Inactivo</option>
                                    <option value="pending">⏳ Pendiente</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer p-4">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-2"></i>
                        Cancelar
                    </button>
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
    
      <script src="{{ asset('dist/js/adminJs/admin.js') }}"></script>