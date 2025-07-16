
document.addEventListener("DOMContentLoaded", function () {
    // Toast auto-dismiss
    const toast = document.getElementById("toast-error");
    if (toast) {
        setTimeout(() => {
            toast.style.opacity = "0";
            toast.style.transition = "opacity 0.5s ease-out";
            setTimeout(() => toast.remove(), 500);
        }, 3000);
    }

    // Toggle password visibility
    const togglePassword = document.querySelector(".toggle-password");
    const passwordInput = document.querySelector("#password");
    if (togglePassword && passwordInput) {
        togglePassword.addEventListener("click", function () {
            const type = passwordInput.type === "password" ? "text" : "password";
            passwordInput.type = type;
            this.classList.toggle("fa-eye");
            this.classList.toggle("fa-eye-slash");
        });
    }

    const toggleConfirmPassword = document.querySelector(".toggle-confirm");
    const confirmInput = document.querySelector("#password_confirmation");
    if (toggleConfirmPassword && confirmInput) {
        toggleConfirmPassword.addEventListener("click", function () {
            const type = confirmInput.type === "password" ? "text" : "password";
            confirmInput.type = type;
            this.classList.toggle("fa-eye");
            this.classList.toggle("fa-eye-slash");
        });
    }

    // Focus first invalid input
    const firstInvalid = document.querySelector(".is-invalid");
    if (firstInvalid) {
        firstInvalid.focus();
    }

    // Phone validation
    const phoneInputField = document.querySelector("#mobile");
    const phoneValidIcon = document.getElementById("phone-valid");
    const phoneInvalidIcon = document.getElementById("phone-invalid");
    const phoneLoadingIcon = document.getElementById("phone-loading");

    // Determine which i18n object to use:
    let i18nOptions = undefined;
    if (window.locale === 'ar') {
        i18nOptions = window.i18nAr;
    }
    else if (window.locale === 'ku') {
        i18nOptions = window.i18nKu;
    }
    // You can add Kurdish later if you have those files similarly loaded

    const iti = window.intlTelInput(phoneInputField, {
        utilsScript: window.utilsScripts.ar,
        onlyCountries: ["iq", "lb", "eg", "jo", "sa", "ae", "om", "kw", "qa", "bh"],
        initialCountry: "auto",
        geoIpLookup: callback => {
            fetch("https://ipapi.co/json")
                .then(res => res.json())
                .then(data => callback(data.country_code))
                .catch(() => callback("iq"));
        },
        nationalMode: true,
        autoPlaceholder: "aggressive",
        formatOnDisplay: true,
        strictMode: true,
        separateDialCode: true,
        i18n: i18nOptions, // pass the Arabic translations here
    });

    const oldPhone = phoneInputField.getAttribute("data-old");
    if (oldPhone) iti.setNumber(oldPhone);

    function updateCountryCode() {
        const countryCode = iti.getSelectedCountryData().dialCode;
        document.getElementById("country_code").value = countryCode;
    }

    function arabicToLatinDigits(input) {
        const arabicDigits = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
        return input.replace(/[٠-٩]/g, d => arabicDigits.indexOf(d));
    }

    phoneInputField.addEventListener("countrychange", updateCountryCode);
    phoneInputField.addEventListener("input", updateCountryCode);
    updateCountryCode();

    function validatePhoneNumber() {
        // Convert Arabic digits to Latin digits first
        let number = phoneInputField.value;
        number = arabicToLatinDigits(number);

        const dialCode = iti.getSelectedCountryData().dialCode;
        const inputOnlyDigits = number.replace(/\D/g, "");

        // Always show loading first
        phoneValidIcon.style.display = "none";
        phoneInvalidIcon.style.display = "none";
        phoneLoadingIcon.style.display = "inline";

        setTimeout(() => {
            const selectedCountry = iti.getSelectedCountryData().iso2;
            let isInvalid = false;

            // Basic invalid patterns
            if (
                number.startsWith("+") ||
                number.startsWith("00") ||
                number.startsWith("0") ||
                inputOnlyDigits.startsWith(dialCode)
            ) {
                isInvalid = true;
            }

            // Iraq-specific rule
            if (selectedCountry === "iq") {
                if (!/^\d{10}$/.test(inputOnlyDigits) || !inputOnlyDigits.startsWith("7")) {
                    isInvalid = true;
                }
            }

            // Final intl-tel-input check
            const countryCode = iti.getSelectedCountryData().dialCode
            const isValid = iti.isValidNumber(number, countryCode);
            const numberType = iti.getNumberType(number, countryCode);

            phoneLoadingIcon.style.display = "none";

            if (!isInvalid && isValid && numberType === 1) {
                phoneValidIcon.style.display = "inline";
            } else {
                phoneInvalidIcon.style.display = "inline";
            }
        }, 300);
    }

    phoneInputField.addEventListener("input", validatePhoneNumber);
    phoneInputField.addEventListener("blur", validatePhoneNumber);

    // Form submission
    const form = document.querySelector("form");
    const dayInput = document.getElementById("dob_day");
    const monthInput = document.getElementById("dob_month");
    const yearInput = document.getElementById("dob_year");
    const hiddenDOB = document.getElementById("DOB");

    form.addEventListener("submit", function (e) {
        const mobileErrorDiv = document.getElementById("mobile-error");
        const mobileDiv = document.querySelector(".phone-group");

        mobileErrorDiv.style.display = "none";
        mobileErrorDiv.textContent = "";
        mobileDiv.classList.remove("is-invalid");

        if (
            !iti.isValidNumber() ||
            iti.getNumberType() !== 1
        ) {
            e.preventDefault();
            mobileErrorDiv.textContent = window.lang_invalid_mobile || "Invalid mobile number.";
            mobileErrorDiv.style.display = "block";
            mobileDiv.classList.add("is-invalid");
            phoneInputField.focus();
        }

        const day = dayInput.value.trim().padStart(2, "0");
        const month = monthInput.value.trim().padStart(2, "0");
        const year = yearInput.value.trim();
        const iso = `${year}-${month}-${day}`;
        const testDate = new Date(iso);

        const dobErrorDiv = document.getElementById("dob-error");
        const dobDiv = document.querySelector(".dob-group");

        dobErrorDiv.style.display = "none";
        dobErrorDiv.textContent = "";
        dobDiv.classList.remove("is-invalid");

        if (
            testDate &&
            testDate.getFullYear() == year &&
            testDate.getMonth() + 1 == parseInt(month) &&
            testDate.getDate() == parseInt(day) &&
            testDate.getFullYear() >= 1900
        ) {
            hiddenDOB.value = iso;
        } else {
            e.preventDefault();
            dobErrorDiv.textContent = window.lang_invalid_date || "Invalid date.";
            dobErrorDiv.style.display = "block";
            dobDiv.classList.add("is-invalid");
        }
    });
});
