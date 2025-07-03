
        // Funcionalidad de búsqueda mejorada
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#usersTable tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                const isVisible = text.includes(searchTerm);
                row.style.display = isVisible ? '' : 'none';
                
                if (isVisible && searchTerm) {
                    row.style.background = 'rgba(29, 181, 132, 0.05)';
                } else {
                    row.style.background = '';
                }
            });
        });

        // Select all checkbox con animación
        document.getElementById('selectAll').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.user-checkbox');
            checkboxes.forEach((checkbox, index) => {
                setTimeout(() => {
                    checkbox.checked = this.checked;
                }, index * 50);
            });
        });

        // Filtros mejorados
        document.getElementById('statusFilter').addEventListener('change', filterTable);
        document.getElementById('roleFilter').addEventListener('change', filterTable);

        function filterTable() {
            const statusFilter = document.getElementById('statusFilter').value.toLowerCase();
            const roleFilter = document.getElementById('roleFilter').value.toLowerCase();
            const rows = document.querySelectorAll('#usersTable tr');
            
            rows.forEach(row => {
                let showRow = true;
                const badges = row.querySelectorAll('.badge');
                
                if (statusFilter && badges.length > 1) {
                    const statusText = badges[1].textContent.toLowerCase();
                    showRow = statusText.includes(statusFilter);
                }
                
                if (roleFilter && showRow && badges.length > 0) {
                    const roleText = badges[0].textContent.toLowerCase();
                    showRow = roleText.includes(roleFilter);
                }
                
                row.style.display = showRow ? '' : 'none';
            });
        }

    // Formulario con validación mejorada
    document.getElementById('addUserForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const password = formData.get('password');
        const confirmPassword = formData.get('password_confirmation');
        
        if (password !== confirmPassword) {
            alert('❌ Las contraseñas no coinciden');
            return;
        }
        
        if (password.length < 6) {
            alert('❌ La contraseña debe tener al menos 6 caracteres');
            return;
        }
        
        // Simulación de creación exitosa
        const modal = bootstrap.Modal.getInstance(document.getElementById('addUserModal'));
        modal.hide();
    });
