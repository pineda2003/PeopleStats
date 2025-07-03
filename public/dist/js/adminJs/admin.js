
        // Funcionalidad del panel de administración
        document.addEventListener('DOMContentLoaded', function() {
            // Búsqueda de usuarios
            const searchInput = document.getElementById('searchInput');
            const statusFilter = document.getElementById('statusFilter');
            const roleFilter = document.getElementById('roleFilter');
            
            // Seleccionar todos los checkboxes
            const selectAll = document.getElementById('selectAll');
            const userCheckboxes = document.querySelectorAll('.user-checkbox');
            
            selectAll.addEventListener('change', function() {
                userCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });
            
            // Funcionalidad de filtros
            function filterUsers() {
                const searchTerm = searchInput.value.toLowerCase();
                const statusValue = statusFilter.value;
                const roleValue = roleFilter.value;
                
                const rows = document.querySelectorAll('#usersTable tr');
                
                rows.forEach(row => {
                    const name = row.querySelector('.fw-semibold')?.textContent.toLowerCase() || '';
                    const email = row.cells[2]?.textContent.toLowerCase() || '';
                    const role = row.querySelector('.badge')?.textContent.toLowerCase() || '';
                    
                    const matchesSearch = name.includes(searchTerm) || email.includes(searchTerm);
                    const matchesStatus = !statusValue || role.includes(statusValue);
                    const matchesRole = !roleValue || role.includes(roleValue);
                    
                    row.style.display = matchesSearch && matchesStatus && matchesRole ? '' : 'none';
                });
            }
            
            searchInput.addEventListener('input', filterUsers);
            statusFilter.addEventListener('change', filterUsers);
            roleFilter.addEventListener('change', filterUsers);
            
            // Botones de acción
            document.querySelectorAll('.btn-view').forEach(btn => {
                btn.addEventListener('click', function() {
                    alert('Ver detalles del usuario');
                });
            });
            
            document.querySelectorAll('.btn-edit').forEach(btn => {
                btn.addEventListener('click', function() {
                    alert('Editar usuario');
                });
            });
            
            document.querySelectorAll('.btn-delete').forEach(btn => {
                btn.addEventListener('click', function() {
                    if (confirm('¿Estás seguro de que quieres eliminar este usuario?')) {
                        alert('Usuario eliminado');
                    }
                });
            });
            
            // Formulario de agregar usuario
            document.getElementById('addUserForm').addEventListener('submit', function(e) {
                e.preventDefault();
                alert('Usuario creado exitosamente');
                document.getElementById('addUserModal').querySelector('.btn-close').click();
            });
        });
