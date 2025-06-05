document.addEventListener('DOMContentLoaded', function () {
    const debounce = (func, delay = 300) => {
        let timeout;
        return (...args) => {
            clearTimeout(timeout);
            timeout = setTimeout(() => func(...args), delay);
        };
    };

    document.querySelectorAll('.search-form').forEach(form => {
        const input = form.querySelector('.search-input');
        const targetSelector = form.dataset.searchTarget;
        const resultsContainer = document.querySelector(targetSelector);
        const action = form.getAttribute('action');

        const fetchResults = debounce(() => {
            const query = input.value;
            const url = new URL(action, window.location.origin);
            url.searchParams.set('query', query);

            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.text())
                .then(html => {
                    resultsContainer.innerHTML = html;
                })
                .catch(error => {
                    console.error('Search error:', error);
                    resultsContainer.innerHTML = '<div class="alert alert-danger">Error loading results.</div>';
                });
        }, 300);

        input.addEventListener('input', fetchResults);
    });
});