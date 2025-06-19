// --------------------------------------------- SIGN UP LOGIC -------------------------------------------- //
document.addEventListener('DOMContentLoaded', function () {
    // ----------------------------
    // 1. Toast auto-dismiss
    // ----------------------------
    const toast = document.getElementById('toast-error');
    if (toast) {
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transition = 'opacity 0.5s ease-out';
            setTimeout(() => toast.remove(), 500);
        }, 3000);
    }

    // ----------------------------
    // 2. Toggle password visibility
    // ----------------------------
    const togglePassword = document.querySelector('.toggle-password');
    const passwordInput = document.querySelector('#password');
    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    }

    // Confirm password
    const toggleConfirmPassword = document.querySelector('.toggle-confirm');
    const confirmInput = document.querySelector('#password_confirmation');
    if (toggleConfirmPassword && confirmInput) {
        toggleConfirmPassword.addEventListener('click', function () {
            const type = confirmInput.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmInput.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    }

    // ----------------------------
    // 3. Focus first invalid input
    // ----------------------------
    const firstInvalid = document.querySelector('.is-invalid');
    if (firstInvalid) {
        firstInvalid.focus();
    }

    // ----------------------------
    // 4. Phone number validation (intl-tel-input)
    // ----------------------------
    const phoneInputField = document.querySelector("#mobile");
    const phoneValidIcon = document.getElementById("phone-valid");
    const phoneLoadingIcon = document.getElementById("phone-loading");

    const iti = window.intlTelInput(phoneInputField, {
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
        onlyCountries: ["iq", "lb", "eg", "jo", "sa", "ae", "om", "kw", "qa", "bh"],
        initialCountry: "auto",
        geoIpLookup: function (callback) {
            fetch('https://ipapi.co/json')
                .then(res => res.json())
                .then(data => callback(data.country_code))
                .catch(() => callback("us"));
        }
    });

    function validatePhoneNumber() {
        const number = phoneInputField.value.trim();
        if (number.length === 0) {
            phoneValidIcon.style.display = "none";
            phoneLoadingIcon.style.display = "none";
            return;
        }

        phoneValidIcon.style.display = "none";
        phoneLoadingIcon.style.display = "inline";

        setTimeout(() => {
            const isValid = iti.isValidNumber();
            phoneLoadingIcon.style.display = "none";
            phoneValidIcon.style.display = isValid ? "inline" : "none";
        }, 400);
    }

    phoneInputField.addEventListener('input', validatePhoneNumber);
    phoneInputField.addEventListener('blur', validatePhoneNumber);

    // ----------------------------
    // 5. Form submission validation
    // ----------------------------
    const form = document.querySelector('form');
    const dayInput = document.getElementById('dob_day');
    const monthInput = document.getElementById('dob_month');
    const yearInput = document.getElementById('dob_year');
    const hiddenDOB = document.getElementById('DOB');

    form.addEventListener('submit', function (e) {
        // Mobile validation
        const mobileErrorDiv = document.getElementById('mobile-error');
        const mobileDiv = document.querySelector('.phone-group');

        mobileErrorDiv.style.display = 'none';
        mobileErrorDiv.textContent = '';
        mobileDiv.classList.remove('is-invalid');

        if (!iti.isValidNumber()) {
            e.preventDefault();
            mobileErrorDiv.textContent = 'Please enter a valid phone number.';
            mobileErrorDiv.style.display = 'block';
            mobileDiv.classList.add('is-invalid');
            phoneInputField.focus();
        }

        // Date validation
        const day = dayInput.value.trim().padStart(2, '0');
        const month = monthInput.value.trim().padStart(2, '0');
        const year = yearInput.value.trim();
        const iso = `${year}-${month}-${day}`;
        const testDate = new Date(iso);

        const dobErrorDiv = document.getElementById('dob-error');
        const dobDiv = document.querySelector('.dob-group');

        dobErrorDiv.style.display = 'none';
        dobErrorDiv.textContent = '';
        dobDiv.classList.remove('is-invalid');

        if (
            testDate &&
            testDate.getFullYear() == year &&
            testDate.getMonth() + 1 == parseInt(month) &&
            testDate.getDate() == parseInt(day) &&
            testDate.getFullYear() >= 1900
        ) {
            hiddenDOB.value = iso;
        } else {
            setTimeout(() => {
                console.log(testDate), 3000;
            })
            e.preventDefault();
            dobErrorDiv.textContent = 'Please enter a valid date in DD / MM / YYYY format.';
            dobErrorDiv.style.display = 'block';
            dobDiv.classList.add('is-invalid');
        }
    });
});

// ----------------------------------------- SIGN IN LOGIC ----------------------------------------------- //
document.addEventListener('DOMContentLoaded', function () {
    // ----------------------------
    // 1. Toast auto-dismiss
    // ----------------------------
    const toast = document.getElementById('toast-error');
    if (toast) {
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transition = 'opacity 0.5s ease-out';
            setTimeout(() => toast.remove(), 500);
        }, 3000);
    }

    // ----------------------------
    // 2. Toggle password visibility
    // ----------------------------
    const togglePassword = document.querySelector('.toggle-password');
    const passwordInput = document.querySelector('#password');

    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    }

    // ----------------------------
    // 3. Focus first invalid input
    // ----------------------------
    const firstInvalid = document.querySelector('.is-invalid');
    if (firstInvalid) {
        firstInvalid.focus();
    }
});