@extends('layouts.admin')

@section('tituloPage', 'Gestión de Usuarios')

@section('contenido')

{{-- Mostrar mensajes de éxito o error --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle me-2"></i>
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Botón Nuevo Usuario -->
<div class="mb-3 text-end">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
        <i class="bi bi-plus-circle me-2"></i>
        Nuevo Usuario
    </button>
</div>

<!-- Filtros y Búsqueda -->
<div class="p-4 border bg-light rounded mb-4">
    <form method="GET" action="{{ route('admin') }}">
        <div class="row align-items-center g-3">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-white border-0">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" class="form-control border-start-0" placeholder="Buscar usuarios por nombre o email..." 
                           name="search" value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-2">
                <select class="form-select" name="role">
                    <option value="">👥 Todos los roles</option>
                    <option value="1" {{ request('role') == '1' ? 'selected' : '' }}>🛡️ Super Admin</option>
                    <option value="2" {{ request('role') == '2' ? 'selected' : '' }}>👨‍💼 Candidato Alcalde</option>
                    <option value="3" {{ request('role') == '3' ? 'selected' : '' }}>👤 Candidato Concejal</option>
                    <option value="4" {{ request('role') == '4' ? 'selected' : '' }}>👤 Líder Comunitario</option>
                </select>
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-outline-primary">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Tabla de Usuarios -->
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th width="50"><input type="checkbox" class="form-check-input" id="selectAll"></th>
                <th>Usuario</th>
                <th>Email</th>
                <th>Rol</th>
             
                <th>Fecha de Registro</th>
                <th width="150">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td><input type="checkbox" class="form-check-input user-checkbox"></td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="user-avatar me-3"><i class="bi bi-person"></i></div>
                        <div>
                            <div class="fw-semibold">{{ $user->name }}</div>
                            <small class="text-muted">ID: {{ $user->id }}</small>
                        </div>
                    </div>
                </td>
                <td>{{ $user->email }}</td>
                <td>
                    @if($user->rol_id == 1)
                        <span class="badge bg-success">🛡️ Super Admin</span>
                    @elseif($user->rol_id == 2)
                        <span class="badge bg-primary">👨‍💼 Candidato Alcalde</span>
                    @elseif($user->rol_id == 3)
                        <span class="badge bg-info">👤 Candidato Concejal</span>
                    @elseif($user->rol_id == 4)
                        <span class="badge bg-warning">👤 Líder Comunitario</span>
                    @else
                        <span class="badge bg-secondary">👤 Usuario</span>
                    @endif
                </td>
               
                <td>{{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y') }}</td>
                <td>
                    <button class="btn btn-sm btn-outline-primary me-1" title="Editar" 
                            data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" 
                          style="display: inline;" onsubmit="return confirm('¿Estás seguro de eliminar este usuario?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>

            <!-- Modal: Editar Usuario -->
            <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                                <h5 class="modal-title"><i class="bi bi-pencil me-2"></i>Editar Usuario</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body p-4">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold"><i class="bi bi-person me-1"></i>Nombre Completo</label>
                                        <input type="text" class="form-control" name="name" value="{{ $user->name }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold"><i class="bi bi-envelope me-1"></i>Email</label>
                                        <input type="email" class="form-control" name="email" value="{{ $user->email }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold"><i class="bi bi-lock me-1"></i>Nueva Contraseña</label>
                                        <input type="password" class="form-control" name="password" placeholder="Dejar vacío para mantener actual">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold"><i class="bi bi-lock-fill me-1"></i>Confirmar Contraseña</label>
                                        <input type="password" class="form-control" name="password_confirmation" placeholder="Confirmar nueva contraseña">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold"><i class="bi bi-shield me-1"></i>Rol</label>
                                        <select class="form-select" name="role" required>
                                            <option value="">Seleccionar rol</option>
                                            <option value="1" {{ $user->rol_id == 1 ? 'selected' : '' }}>🛡️ Super Administrador</option>
                                            <option value="2" {{ $user->rol_id == 2 ? 'selected' : '' }}>👨‍💼 Candidato Alcalde</option>
                                            <option value="3" {{ $user->rol_id == 3 ? 'selected' : '' }}>👤 Candidato Concejal</option>
                                            <option value="4" {{ $user->rol_id == 4 ? 'selected' : '' }}>👤 Líder Comunitario</option>
                                        </select>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="modal-footer p-4">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    <i class="bi bi-x-circle me-2"></i>Cancelar
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-2"></i>Actualizar Usuario
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <tr>
                <td colspan="7" class="text-center py-4">
                    <i class="bi bi-people text-muted" style="font-size: 3rem;"></i>
                    <p class="text-muted mt-2">No hay usuarios registrados</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Paginación -->
<div class="p-3 d-flex justify-content-between align-items-center">
    <small class="text-muted">
        Mostrando {{ $users->firstItem() }}-{{ $users->lastItem() }} de {{ $users->total() }} usuarios
    </small>
    {{ $users->appends(request()->query())->links() }}
</div>

<!-- Modal: Agregar Usuario -->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-person-plus me-2"></i>Agregar Nuevo Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold"><i class="bi bi-person me-1"></i>Nombre Completo</label>
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold"><i class="bi bi-envelope me-1"></i>Email</label>
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold"><i class="bi bi-lock me-1"></i>Contraseña</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold"><i class="bi bi-lock-fill me-1"></i>Confirmar Contraseña</label>
                            <input type="password" class="form-control" name="password_confirmation" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold"><i class="bi bi-shield me-1"></i>Rol</label>
                            <select class="form-select" name="role" required>
                                <option value="">Seleccionar rol</option>
                                
                                <option value="2" {{ old('role') == '2' ? 'selected' : '' }}>👨‍💼 Candidato Alcalde</option>
                                <option value="3" {{ old('role') == '3' ? 'selected' : '' }}>👤 Candidato Concejal</option>
                                <option value="4" {{ old('role') == '4' ? 'selected' : '' }}>👤 Líder Comunitario</option>
                            </select>
                        </div>
                       
                    </div>
                </div>
                <div class="modal-footer p-4">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-2"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-2"></i>Crear Usuario
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection