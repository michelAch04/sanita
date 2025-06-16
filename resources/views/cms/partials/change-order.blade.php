<script>
document.addEventListener('DOMContentLoaded', () => {
    window.csrfToken = "{{ csrf_token() }}";
    document.querySelectorAll('[data-sortable-table]').forEach(table => {
        const tbody = table.querySelector('tbody');
        const reorderUrl = table.dataset.reorderUrl;

        if (!reorderUrl || !tbody) return;

        Sortable.create(tbody, {
            handle: '.handle',
            animation: 150,
            onEnd: function () {
                const order = [...tbody.children].map((row, index) => {
                    return {
                        id: row.dataset.id,
                        position: index + 1
                    };
                });

                console.log(order);
                console.log(reorderUrl);
                fetch(reorderUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': window.csrfToken // declared in Blade
                    },
                    body: JSON.stringify({ order })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        console.log('Order updated.');
                    }
                })
                .catch(err => console.error(err));
            }
        });
    });
});
</script>