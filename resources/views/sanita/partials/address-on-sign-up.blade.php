<div class="modal fade" id="addAddressModal" tabindex="-1" aria-labelledby="addAddressLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg d-flex justify-content-center">
        <div class="modal-content p-3 pb-2" style="width: 75%;">
            <div class="modal-header" style="border: none !important;">
                <h2 class="display-5 login-title text-center mb-0" style="font-size: 2.5rem;">{{ __('nav.add_first_address') }}</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('Close') }}"></button>
            </div>
            <div class="modal-body d-flex justify-content-center flex-column">
                <p class="text-center address-msg">
                    <i class="fa-solid fa-warning"></i>
                    {{ __('nav.add_address_required') }}
                </p>
                @include('sanita.addresses.create') {{-- We'll extract the form here --}}
            </div>
        </div>
    </div>
</div>
<style>
    .address-msg {
        animation: glow 1s infinite;
        color: rgb(194, 160, 66);
        transition: transform 0.3s ease, color 0.3s ease;
    }
    @keyframes glow {
        0%{
            transform: scale(1);
        }
        50% {
            transform: scale(1.015);
        }
        100% {
            transform: scale(1);
        }
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var modalEl = document.getElementById('addAddressModal');
        var modal = new bootstrap.Modal(document.getElementById('addAddressModal'), {
            backdrop: 'static',
            keyboard: false
        });
        modal.show();

        // Optionally, disable the close button
        document.querySelectorAll('#addAddressModal .btn-close').forEach(function(btn) {
            btn.style.display = 'none';
        });
        // Prevent modal from closing and make message glow
        modalEl.addEventListener('hide.bs.modal', function(e) {
            e.preventDefault();
            var msg = modalEl.querySelector('.add-address-glow');
            if (msg) {
                msg.classList.add('glow');
                setTimeout(function() {
                    msg.classList.remove('glow');
                }, 1000);
            }
        });
    });
</script>