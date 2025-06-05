        document.addEventListener('DOMContentLoaded', () => {
            // Toasts auto show
            document.querySelectorAll('.toast').forEach(toastEl => {
                new bootstrap.Toast(toastEl, {
                    delay: 5000
                }).show();
            });

            // Delete confirmation logic
            window.confirmDelete = function(routeTemplate) {
                const form = document.getElementById('deleteForm');
                form.action = routeTemplate;
                const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('deleteModal'));
                modal.show();
            };
        });