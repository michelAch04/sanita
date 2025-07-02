<style>
    .floating-contact {
        position: fixed;
        bottom: 1rem;
        /* 16px */
        right: 1rem;
        /* 16px */
        z-index: 9;
        background-color: var(--primary-blue);
        color: white;
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
        background-color: var(--link-blue);
        color: var(--primary-blue);
        border: 2px solid var(--primary-blue);
    }

    .floating-contact i {
        font-size: 2.25rem;
        /* 36px */
    }

    @media (max-width: 768px) {
        .floating-contact {
            padding: 0.75rem;
            /* 12px */
        }

        .floating-contact i {
            font-size: 1.125rem;
            /* 18px */
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

<a href="https://wa.me/96171999874?text=Hello%20Sanita%20Iraq" class="floating-contact" title="{{ __('nav.contact') }}" target="_blank">
    <i class="fab fa-whatsapp"></i>
</a>

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