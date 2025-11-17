<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" href="{{ asset('storage/login/sanita.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            background: url("{{ asset('storage/login/bgsanita.jpg') }}") no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.06);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-radius: 20px;
            padding: 60px 40px;

            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.25);
            color: #fff;
            height: fit-content;
            /* display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column; */
        }

        .glass-card input,
        .glass-card label {
            color: #fff;
        }

        .glass-card input::placeholder {
            color: #e0e0e0;
        }

        .glass-card .form-control {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        input:-webkit-autofill {
            color: #fff !important;
            -webkit-text-fill-color: #fff !important;
            transition: background-color 5000s ease-in-out 0s;
        }

        .btn-primary {
            background-color: #38B2AC;
            border: none;
        }

        .btn-primary:hover {
            background-color: rgb(46, 159, 153);
        }

        .btn-primary:focus,
        .btn-primary:active {
            background-color: rgb(24, 108, 104) !important;
        }

        .glass-container {
            margin-top: 0 !important;
            padding-top: 0 !important;
        }

        .form-control,
        .form-control:focus,
        .form-control:active {
            color: #fff !important;
        }

        .form-control:focus,
        .form-control:active {
            box-shadow: 0 0 10px #38B2AC;
        }

        .custom-toast-card {
            width: auto;
            height: 80px;
            border-radius: 8px;
            box-sizing: border-box;
            padding: 10px 15px;
            background-color: #ffffff;
            box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: space-around;
            gap: 15px;
        }

        .custom-toast-card .wave {
            position: absolute;
            transform: rotate(90deg);
            left: -31px;
            top: 32px;
            width: 80px;
        }

        .custom-toast-card .icon-container {
            width: 2rem !important;
            height: 2rem !important;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #04e40048;
            border-radius: 50% !important;
            margin-left: 8px;
            font-size: 18px;
        }

        .error-toast .custom-toast-card .icon-container {
            width: 2.5rem !important;
        }

        .custom-toast-card .message-text-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            flex-grow: 1;
        }

        .custom-toast-card .message-text,
        .custom-toast-card .sub-text {
            margin: 0;
            cursor: default;
        }

        .custom-toast-card .message-text {
            color: #269b24;
            font-size: 17px;
            font-weight: 700;
        }

        .info-toast .custom-toast-card .custom-toast-card .sub-text {
            font-size: 14px;
            color: #555;
        }
    </style>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center glass-container vh-100">
        <div class="glass-card w-100 d-flex justify-content-between flex-column" style="max-width: 400px;">
            <!-- Centered Image -->
            <div class="text-center mb-4">
                <img src="{{ asset('storage/login/sanita.png') }}" alt="Logo" class="img-fluid" style="max-width: 180px;">
            </div>
            <h3 class="text-center mb-5 fw-semibold">Login</h3>

            <form method="POST" action="{{ route('admin.login') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" required>
                </div>

                <div style="margin-bottom: 2.2rem;">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
                        <button type="button" class="btn btn-outline-light" id="togglePassword">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-lg rounded-pill btn-primary">Login</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const passwordInput = document.querySelector('#password');

        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.innerHTML = type === 'password' ? '<i class="bi bi-eye"></i>' : '<i class="bi bi-eye-slash"></i>';
        });
    </script>

    <script src="{{ asset('js/modals.js') }}"></script>

    @if ($errors->any())
    <script>
        showAjaxToast("failed", "{{ $errors->first() }}");
    </script>
    @endif
</body>

</html>