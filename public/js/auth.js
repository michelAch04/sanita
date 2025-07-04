// --------------------------------------------- SIGN UP LOGIC -------------------------------------------- //
document.addEventListener("DOMContentLoaded", function () {
    // ----------------------------
    // 1. Toast auto-dismiss
    // ----------------------------
    const toast = document.getElementById("toast-error");
    if (toast) {
        setTimeout(() => {
            toast.style.opacity = "0";
            toast.style.transition = "opacity 0.5s ease-out";
            setTimeout(() => toast.remove(), 500);
        }, 3000);
    }

    // ----------------------------
    // 2. Toggle password visibility
    // ----------------------------
    const togglePassword = document.querySelector(".toggle-password");
    const passwordInput = document.querySelector("#password");
    console.log(passwordInput, togglePassword);
    if (togglePassword && passwordInput) {
        togglePassword.addEventListener("click", function () {
            const type =
                passwordInput.getAttribute("type") === "password"
                    ? "text"
                    : "password";
            passwordInput.setAttribute("type", type);
            this.classList.toggle("fa-eye");
            this.classList.toggle("fa-eye-slash");
        });
    }

    // Confirm password
    const toggleConfirmPassword = document.querySelector(".toggle-confirm");
    const confirmInput = document.querySelector("#password_confirmation");
    if (toggleConfirmPassword && confirmInput) {
        toggleConfirmPassword.addEventListener("click", function () {
            const type =
                confirmInput.getAttribute("type") === "password"
                    ? "text"
                    : "password";
            confirmInput.setAttribute("type", type);
            this.classList.toggle("fa-eye");
            this.classList.toggle("fa-eye-slash");
        });
    }

    // ----------------------------
    // 3. Focus first invalid input
    // ----------------------------
    const firstInvalid = document.querySelector(".is-invalid");
    if (firstInvalid) {
        firstInvalid.focus();
    }

    // ----------------------------
    // 4. Phone number validation (intl-tel-input)
    // ----------------------------
    const phoneInputField = document.querySelector("#mobile");
    const phoneValidIcon = document.getElementById("phone-valid");
    const phoneInvalidIcon = document.getElementById("phone-invalid");
    const phoneLoadingIcon = document.getElementById("phone-loading");

    if (!phoneInputField) return;

    const iti = window.intlTelInput(phoneInputField, {
        utilsScript:
            "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
        onlyCountries: [
            "iq",
            "lb",
            "eg",
            "jo",
            "sa",
            "ae",
            "om",
            "kw",
            "qa",
            "bh",
        ],
        initialCountry: "iq", // Default to Iraq
        nationalMode: true,
        autoPlaceholder: "aggressive",
        formatOnDisplay: false,
        separateDialCode: true,
    });

    // Restore previous phone value and flag
    const oldPhone = phoneInputField.getAttribute("data-old");
    if (oldPhone) {
        iti.setNumber(oldPhone);
    }

    function updateCountryCode() {
        const countryCode = iti.getSelectedCountryData().dialCode;
        document.getElementById("country_code").value = countryCode;
    }

    phoneInputField.addEventListener("countrychange", updateCountryCode);
    phoneInputField.addEventListener("input", updateCountryCode);
    updateCountryCode(); // Initial set

    function validatePhoneNumber() {
        const number = phoneInputField.value.trim();
        const dialCode = iti.getSelectedCountryData().dialCode;
        const inputOnlyDigits = number.replace(/\D/g, "");

        phoneValidIcon.style.display = "none";
        phoneInvalidIcon.style.display = "none";
        phoneLoadingIcon.style.display = "none";

        // Reject if starts with +, 00, 0, or country code
        if (
            number.startsWith("+") ||
            number.startsWith("00") ||
            number.startsWith("0") ||
            inputOnlyDigits.startsWith(dialCode)
        ) {
            phoneInvalidIcon.style.display = "inline";
            return;
        }

        // Special validation for Iraq (10-digit, start with 7)
        const selectedCountry = iti.getSelectedCountryData().iso2;
        if (selectedCountry === "iq") {
            if (
                !/^\d{10}$/.test(inputOnlyDigits) ||
                !inputOnlyDigits.startsWith("7")
            ) {
                phoneInvalidIcon.style.display = "inline";
                return;
            }
        }

        phoneLoadingIcon.style.display = "inline";

        setTimeout(() => {
            const isValid = iti.isValidNumber();
            const numberType = iti.getNumberType();

            phoneLoadingIcon.style.display = "none";

            if (isValid && numberType === intlTelInputUtils.numberType.MOBILE) {
                phoneValidIcon.style.display = "inline";
            } else {
                phoneInvalidIcon.style.display = "inline";
            }
        }, 300);
    }

    phoneInputField.addEventListener("input", validatePhoneNumber);
    phoneInputField.addEventListener("blur", validatePhoneNumber);
    // ----------------------------
    // 5. Form submission validation
    // ----------------------------
    const form = document.querySelector("form");
    const dayInput = document.getElementById("dob_day");
    const monthInput = document.getElementById("dob_month");
    const yearInput = document.getElementById("dob_year");
    const hiddenDOB = document.getElementById("DOB");

    form.addEventListener("submit", function (e) {
        // Mobile validation
        const mobileErrorDiv = document.getElementById("mobile-error");
        const mobileDiv = document.querySelector(".phone-group");

        mobileErrorDiv.style.display = "none";
        mobileErrorDiv.textContent = "";
        mobileDiv.classList.remove("is-invalid");

        if (
            !iti.isValidNumber() ||
            numberType !== intlTelInputUtils.numberType.MOBILE
        ) {
            e.preventDefault();
            mobileErrorDiv.textContent = "Please enter a valid mobile number.";
            mobileErrorDiv.style.display = "block";
            mobileDiv.classList.add("is-invalid");
            phoneInputField.focus();
        }

        // Date validation
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
            setTimeout(() => {
                console.log(testDate), 3000;
            });
            e.preventDefault();
            dobErrorDiv.textContent =
                "Please enter a valid date in DD / MM / YYYY format.";
            dobErrorDiv.style.display = "block";
            dobDiv.classList.add("is-invalid");
        }
    });
});
