// Read CSRF token immediately on script parse (before DOMContentLoaded)
(function () {
    if (!window.csrfToken) {
        var meta = document.querySelector('meta[name="csrf-token"]');
        if (meta) window.csrfToken = meta.getAttribute('content');
    }
})();

// Top-level function — always available as soon as this script loads,
// regardless of DOMContentLoaded timing or toast errors.
function confirmDelete(routeTemplate) {
    // Force same protocol as current page to prevent mixed-content blocks on HTTPS
    try {
        var u = new URL(routeTemplate);
        u.protocol = window.location.protocol;
        routeTemplate = u.href;
    } catch (e) {}

    var modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('deleteModal'));
    modal.show();

    var btn = document.getElementById('deleteConfirmBtn');
    // Clone to remove any previously attached listeners
    var newBtn = btn.cloneNode(true);
    btn.parentNode.replaceChild(newBtn, btn);

    newBtn.addEventListener('click', function () {
        modal.hide();
        fetch(routeTemplate, {
            method: 'POST',
            redirect: 'manual',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-TOKEN': window.csrfToken,
            },
            body: '_method=DELETE',
        }).then(function (response) {
            // opaqueredirect = server redirected after delete (success)
            if (response.ok || response.redirected || response.type === 'opaqueredirect') {
                window.location.reload();
            } else {
                showAjaxToast('failed', 'Failed to delete. Please try again.');
            }
        }).catch(function () {
            showAjaxToast('failed', 'Network error. Please try again.');
        });
    });
}

document.addEventListener('DOMContentLoaded', function () {
    // Re-read CSRF in case the meta tag wasn't available during initial parse
    if (!window.csrfToken) {
        var meta = document.querySelector('meta[name="csrf-token"]');
        if (meta) window.csrfToken = meta.getAttribute('content');
    }

    // Toasts auto show — wrapped so a Bootstrap CDN failure can't throw here
    try {
        document.querySelectorAll('.toast').forEach(function (toastEl) {
            new bootstrap.Toast(toastEl, { delay: 5000 }).show();
        });
    } catch (e) {}
});

function showAjaxToast(status, message) {
    // Remove existing toasts
    $(".toast-container").remove();

    const rtlContainer = window.isRtl ? "rtl-container" : "";

    // Determine position based on URL
    const isCartPage = window.location.pathname.includes('/cart');
    const positionClass = isCartPage ? 'top-0 start-0 mt-5 ms-3' : 'bottom-0 end-0 p-3';

    if(!window.toastMessages) {
        window.toastMessages = {
            success: 'Success!',
            failed: 'Error',
            warning: 'Warning'
        };
    }

    let toastHTML = '';

    if (status === 'success') {
        toastHTML = `
        <div class="toast-container position-fixed ${positionClass} ${rtlContainer}" style="z-index: 9999;">
            <div class="toast success-toast show border-0 p-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="custom-toast-card bg-white p-2">
                    <svg class="wave" viewBox="0 0 1440 320" xmlns="http://www.w3.org/2000/svg">
                        <path
                        d="M0,256L11.4,240C22.9,224,46,192,69,192C91.4,192,114,224,137,234.7C160,245,183,235,206,213.3C228.6,192,251,160,274,149.3C297.1,139,320,149,343,181.3C365.7,213,389,267,411,282.7C434.3,299,457,277,480,250.7C502.9,224,526,192,549,181.3C571.4,171,594,181,617,208C640,235,663,277,686,256C708.6,235,731,149,754,122.7C777.1,96,800,128,823,165.3C845.7,203,869,245,891,224C914.3,203,937,117,960,112C982.9,107,1006,181,1029,197.3C1051.4,213,1074,171,1097,144C1120,117,1143,107,1166,133.3C1188.6,160,1211,224,1234,218.7C1257.1,213,1280,139,1303,133.3C1325.7,128,1349,192,1371,192C1394.3,192,1417,128,1429,96L1440,64L1440,320L0,320Z"
                        fill="#04e4003a" fill-opacity="1"></path>
                    </svg>
                    <div class="icon-container"><i class="fa-regular fa-circle-check text-success"></i></div>
                    <div class="message-text-container">
                        <p class="message-text">${
                            window.toastMessages.success || "Success!"
                        }</p>
                        <p class="sub-text">${message}</p>
                    </div>
                    <button type="button" class="btn-close me-1" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>`;
    } else if (status === "failed") {
        toastHTML = `
        <div class="toast-container position-fixed ${positionClass} ${rtlContainer}" style="z-index: 9999;">
            <div class="toast error-toast show border-0 p-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="custom-toast-card bg-white p-2" style="--toast-color: #dc3545; --toast-bg: #dc354533;">
                        <svg class="wave" viewBox="0 0 1440 320" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M0,256L11.4,240C22.9,224,46,192,69,192C91.4,192,114,224,137,234.7C160,245,183,235,206,213.3C228.6,192,251,160,274,149.3C297.1,139,320,149,343,181.3C365.7,213,389,267,411,282.7C434.3,299,457,277,480,250.7C502.9,224,526,192,549,181.3C571.4,171,594,181,617,208C640,235,663,277,686,256C708.6,235,731,149,754,122.7C777.1,96,800,128,823,165.3C845.7,203,869,245,891,224C914.3,203,937,117,960,112C982.9,107,1006,181,1029,197.3C1051.4,213,1074,171,1097,144C1120,117,1143,107,1166,133.3C1188.6,160,1211,224,1234,218.7C1257.1,213,1280,139,1303,133.3C1325.7,128,1349,192,1371,192C1394.3,192,1417,128,1429,96L1440,64L1440,320L0,320Z"
                                fill="var(--toast-bg)" fill-opacity="1">
                            </path>
                        </svg>
                    <div class="icon-container" style="background-color: var(--toast-bg);">
                        <i class="fa-regular fa-circle-xmark text-danger"></i>
                    </div>
                    <div class="message-text-container">
                        <p class="message-text" style="color: var(--toast-color);">${
                            window.toastMessages.failed || "Error"
                        }</p>
                        <p class="sub-text">${message}</p>
                    </div>
                    <button type="button" class="btn-close me-1" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>`;
    } else if (status === "warning") {
        toastHTML = `
    <div class="toast-container position-fixed ${positionClass} ${rtlContainer}" style="z-index: 9999;">
        <div class="toast warning-toast show border-0 p-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="custom-toast-card bg-white p-2" style="--toast-color: #ffc107; --toast-bg: #ffc10733;">
                <svg class="wave" viewBox="0 0 1440 320" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M0,256L11.4,240C22.9,224,46,192,69,192C91.4,192,114,224,137,234.7C160,245,183,235,206,213.3C228.6,192,251,160,274,149.3C297.1,139,320,149,343,181.3C365.7,213,389,267,411,282.7C434.3,299,457,277,480,250.7C502.9,224,526,192,549,181.3C571.4,171,594,181,617,208C640,235,663,277,686,256C708.6,235,731,149,754,122.7C777.1,96,800,128,823,165.3C845.7,203,869,245,891,224C914.3,203,937,117,960,112C982.9,107,1006,181,1029,197.3C1051.4,213,1074,171,1097,144C1120,117,1143,107,1166,133.3C1188.6,160,1211,224,1234,218.7C1257.1,213,1280,139,1303,133.3C1325.7,128,1349,192,1371,192C1394.3,192,1417,128,1429,96L1440,64L1440,320L0,320Z"
                        fill="var(--toast-bg)" fill-opacity="1">
                    </path>
                </svg>
                <div class="icon-container" style="background-color: var(--toast-bg);">
                    <i class="fa-solid fa-triangle-exclamation text-warning"></i>
                </div>
                <div class="message-text-container">
                    <p class="message-text" style="color: var(--toast-color);">${
                        window.toastMessages.warning || "Warning"
                    }</p>
                    <p class="sub-text">${message}</p>
                </div>
                <button type="button" class="btn-close me-1" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>`;
    }

    $("body").append(toastHTML);

    const toastEl = document.querySelector(".toast");
    if (toastEl) {
        new bootstrap.Toast(toastEl, { delay: 5000 }).show();
    }
}
