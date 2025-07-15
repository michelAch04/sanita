<style>
    .floating-contact {
        position: fixed;
        right: 1rem;
        /* 16px */
        z-index: 9;
        border-radius: 50%;
        width: 3.5rem;
        height: 3.5rem;
        padding: 0.875rem;
        /* 14px */
        box-shadow: 0 0.25rem 0.625rem rgba(0, 0, 0, 0.3);
        /* 4px 10px */
        transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
    }

    .floating-contact:hover {
        border: 2px solid var(--primary-blue);
    }

    .floating-contact i {
        font-size: 2.25rem;
        /* 36px */
    }

    @media (max-width: 576px) {
        .floating-contact {
            width: 2.5rem;
            height: 2.5rem;
            margin: 0 !important;
            padding: 0.75rem;
            /* 12px */
            right: 0.5rem;
        }

        .floating-contact i {
            font-size: 1.6rem;
            /* 18px */
        }
        .floating-contact:hover, .floating-contact:active, .floating-contact:focus {
            background: var(--primary-blue) !important;
            color: var(--light-text);
            border: none !important;
        }
    }

    @keyframes phone-shake {
        0% {
            transform: rotate(0deg) translate(0, 0);
        }

        20% {
            transform: rotate(5deg) translate(0.125rem, -0.125rem);
        }

        /* 2px */
        40% {
            transform: rotate(-5deg) translate(-0.125rem, 0.125rem);
        }

        60% {
            transform: rotate(5deg) translate(0.125rem, -0.125rem);
        }

        80% {
            transform: rotate(-5deg) translate(-0.125rem, 0.125rem);
        }

        100% {
            transform: rotate(0deg) translate(0, 0);
        }
    }

    .shake {
        animation: phone-shake 0.6s ease-in-out;
    }
</style>
<div class="position-relative overflow-hidden w-100"></div>
<a href="https://wa.me/96171999874?text=Hello%20Sanita%20Iraq" class="floating-contact btn btn-arctic" title="{{ __('nav.contact') }}" target="_blank">
    <i class="fab fa-whatsapp"></i>
</a>
</div>
<script>
    window.addEventListener('DOMContentLoaded', () => {
        setTimeout(() => {
            const icon = document.querySelector('.floating-contact');
            if (icon) {
                icon.classList.add('shake');
                setTimeout(() => {
                    icon.classList.remove('shake');
                }, 600);
            }
        }, 3000);
    });

    function adjustFloatingContact() {
        const floatingContact = document.querySelector('.floating-contact');
        const footer = document.querySelector('footer.footer');
        if (!floatingContact || !footer) return;

        const footerRect = footer.getBoundingClientRect();
        const viewportHeight = window.innerHeight;

        const footerVisibleHeight = viewportHeight - footerRect.top;
        const defaultBottom = 16; // 1rem

        if (footerVisibleHeight > 0) {
            floatingContact.style.bottom = (footerVisibleHeight + defaultBottom) + 'px';
        } else {
            floatingContact.style.bottom = defaultBottom + 'px';
        }
    }

    window.addEventListener('scroll', adjustFloatingContact);
    window.addEventListener('resize', adjustFloatingContact);
    window.addEventListener('load', adjustFloatingContact);
</script>