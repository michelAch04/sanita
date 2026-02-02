document.addEventListener("DOMContentLoaded", function () {
    // ====================== TOAST AUTO-DISMISS ====================== //
    const toast = document.getElementById("toast-error");
    if (toast) {
        setTimeout(() => {
            toast.style.opacity = "0";
            toast.style.transition = "opacity 0.5s ease-out";
            setTimeout(() => toast.remove(), 500);
        }, 3000);
    }

    // ====================== TOGGLE PASSWORD VISIBILITY ====================== //
    const togglePassword = document.querySelector(".toggle-password");
    const passwordInput = document.querySelector("#password");
    if (togglePassword && passwordInput) {
        togglePassword.addEventListener("click", function () {
            passwordInput.type = passwordInput.type === "password" ? "text" : "password";
            this.classList.toggle("fa-eye");
            this.classList.toggle("fa-eye-slash");
        });
    }

    const toggleConfirmPassword = document.querySelector(".toggle-confirm");
    const confirmInput = document.querySelector("#password_confirmation");
    if (toggleConfirmPassword && confirmInput) {
        toggleConfirmPassword.addEventListener("click", function () {
            confirmInput.type = confirmInput.type === "password" ? "text" : "password";
            this.classList.toggle("fa-eye");
            this.classList.toggle("fa-eye-slash");
        });
    }

    // ====================== FOCUS FIRST INVALID ====================== //
    const firstInvalid = document.querySelector(".is-invalid");
    if (firstInvalid) firstInvalid.focus();

    // ====================== AR→EN DIGIT NORMALIZATION ====================== //
    function normalizeDigits(input) {
        const arabicIndic = ['\u0660', '\u0661', '\u0662', '\u0663', '\u0664', '\u0665', '\u0666', '\u0667', '\u0668', '\u0669'];
        const easternArabicIndic = ['\u06F0', '\u06F1', '\u06F2', '\u06F3', '\u06F4', '\u06F5', '\u06F6', '\u06F7', '\u06F8', '\u06F9'];
        return input.replace(/[\u0660-\u0669\u06F0-\u06F9]/g, (d) => {
            let i = arabicIndic.indexOf(d);
            if (i === -1) i = easternArabicIndic.indexOf(d);
            return i > -1 ? i : d;
        });
    }

    function containsArabic(text) {
        return /[\u0600-\u06FF\u0750-\u077F\u08A0-\u08FF]/.test(text);
    }

    // ====================== PHONE VALIDATION ====================== //
    const phoneInputField = document.querySelector("#mobile");
    const phoneValidIcon = document.getElementById("phone-valid");
    const phoneInvalidIcon = document.getElementById("phone-invalid");
    const phoneLoadingIcon = document.getElementById("phone-loading");

    let i18nOptions;
    if (window.locale === "ar" && window.i18nAr) i18nOptions = window.i18nAr;
    else if (window.locale === "ku" && window.i18nKu) i18nOptions = window.i18nKu;

    const iti = window.intlTelInput(phoneInputField, {
        utilsScript: window.utilsScripts.ar ?? window.utilsScript.default,
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
        i18n: i18nOptions,
    });

    const oldPhone = phoneInputField.getAttribute("data-old");
    if (oldPhone) iti.setNumber(oldPhone);

    function updateCountryCode() {
        const countryCode = iti.getSelectedCountryData().dialCode;
        document.getElementById("country_code").value = countryCode;
    }

    phoneInputField.addEventListener("countrychange", updateCountryCode);
    phoneInputField.addEventListener("input", updateCountryCode);
    updateCountryCode();

    function validatePhoneNumber() {
        let number = phoneInputField.value;

        // Normalize Arabic digits
        if (containsArabic(number)) {
            number = normalizeDigits(number);
            phoneInputField.value = number;
        }

        // Strip leading zeros if length > 2
        if (number.startsWith("0") && number.length > 2) {
            number = number.replace(/^0+/, "");
            phoneInputField.value = number;
        }

        const dialCode = iti.getSelectedCountryData().dialCode;
        const inputOnlyDigits = number.replace(/\D/g, "");

        phoneValidIcon.style.display = "none";
        phoneInvalidIcon.style.display = "none";
        phoneLoadingIcon.style.display = "inline";

        setTimeout(() => {
            let isInvalid = false;

            if (
                number.startsWith("+") ||
                number.startsWith("00") ||
                inputOnlyDigits.startsWith(dialCode)
            ) {
                isInvalid = true;
            }

            const isValid = iti.isValidNumber(number, dialCode);
            const numberType = iti.getNumberType(number, dialCode);

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

    // ====================== DATE VALIDATION ====================== //
    function normalizeDateField(input) {
        input.addEventListener("input", function () {
            this.value = normalizeDigits(this.value);
        });
        input.addEventListener("blur", function () {
            this.value = normalizeDigits(this.value);
        });
    }

    function clamp(num, min, max) {
        return Math.min(Math.max(num, min), max);
    }

    function formatAndClamp(input, min, max, nextInput = null) {
        normalizeDateField(input);
        input.addEventListener("input", function () {
            if (!/^\d+$/.test(this.value)) this.value = "";
            if (this.value.length === 2) {
                this.value = clamp(parseInt(this.value, 10), min, max)
                    .toString().padStart(2, "0");
                if (nextInput) nextInput.focus();
            }
        });
        input.addEventListener("blur", function () {
            if (this.value.length === 1) {
                this.value = clamp(parseInt(this.value, 10), min, max)
                    .toString().padStart(2, "0");
            }
        });
    }

    const dayInput = document.getElementById("dob_day");
    const monthInput = document.getElementById("dob_month");
    const yearInput = document.getElementById("dob_year");
    const hiddenDOB = document.getElementById("DOB");

    if (dayInput && monthInput && yearInput) {
        formatAndClamp(dayInput, 1, 31, monthInput);
        formatAndClamp(monthInput, 1, 12, yearInput);
        normalizeDateField(yearInput);
    }

    if (yearInput) {
        yearInput.addEventListener("input", function () {
            if (!/^\d+$/.test(this.value)) this.value = "";
        });
    }

    // ====================== FORM SUBMISSION ====================== //
    const form = document.querySelector("form");
    form.addEventListener("submit", function (e) {
        const mobileErrorDiv = document.getElementById("mobile-error");
        const mobileDiv = document.querySelector(".phone-group");
        mobileErrorDiv.style.display = "none";
        mobileDiv.classList.remove("is-invalid");

        if (!iti.isValidNumber() || iti.getNumberType() !== 1) {
            e.preventDefault();
            mobileErrorDiv.textContent = window.lang_invalid_mobile || "Invalid mobile number.";
            mobileErrorDiv.style.display = "block";
            mobileDiv.classList.add("is-invalid");
            phoneInputField.focus();
            return;
        }

        const day = dayInput.value.trim().padStart(2, "0");
        const month = monthInput.value.trim().padStart(2, "0");
        const year = yearInput.value.trim();
        const iso = `${year}-${month}-${day}`;
        const testDate = new Date(iso);

        const dobErrorDiv = document.getElementById("dob-error");
        const dobDiv = document.querySelector(".dob-group");
        dobErrorDiv.style.display = "none";
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