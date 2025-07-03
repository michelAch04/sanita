<script>
    document.addEventListener('DOMContentLoaded', () => {
        let reorderEnabled = true; // For toggle

        document.querySelectorAll('[data-sortable-table]').forEach(table => {
            const tbody = table.querySelector('tbody');
            const reorderUrl = table.dataset.reorderUrl;

            if (!reorderUrl || !tbody) return;

            const sortable = Sortable.create(tbody, {
                handle: '.handle',
                animation: 150,
                scroll: true,
                scrollSensitivity: 100,
                scrollSpeed: 10,
                ghostClass: 'sortable-ghost',
                chosenClass: 'sortable-chosen',
                dragClass: 'dragging-row',

                onStart: function() {
                    if (navigator.vibrate) navigator.vibrate(50); // Haptic buzz
                },

                onMove: function() {
                    return reorderEnabled; // Prevent move if toggled off
                },

                onEnd: function() {
                    const order = [...tbody.children].map((row, index) => ({
                        id: row.dataset.id,
                        position: index + 1
                    }));

                    // Highlight updated rows
                    tbody.querySelectorAll('tr').forEach(row => {
                        row.classList.add('reordered');
                        setTimeout(() => row.classList.remove('reordered'), 1000);
                    });

                    fetch(reorderUrl, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': window.csrfToken
                            },
                            body: JSON.stringify({
                                order
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {

                            }
                        })
                        .catch(err => console.error(err));
                }
            });
        });

    });
</script>

<style>
    .sortable-ghost {
        background-color: #f0f9ff !important;
        opacity: 0.7;
    }

    .sortable-chosen {
        background-color: rgb(243, 255, 250) !important;
    }

    .dragging-row {
        opacity: 0.5;
    }

    .reordered {
        background-color:rgb(243, 255, 251) !important;
        transition: background-color 0.5s ease;
    }
</style>