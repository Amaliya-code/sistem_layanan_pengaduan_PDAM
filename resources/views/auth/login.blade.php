<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login PDAM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #0d6efd, #20c997);
            height: 100vh;
        }

        .login-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .login-header {
            background: #0d6efd;
            color: white;
            text-align: center;
            padding: 20px;
        }

        .form-control {
            border-radius: 10px;
        }

        .btn-login {
            border-radius: 10px;
            background: #0d6efd;
            color: white;
            font-weight: 600;
        }

        .btn-login:hover {
            background: #0b5ed7;
        }

        .eye-btn {
            cursor: pointer;
            background: #f1f1f1;
            border-left: none;
        }
    </style>
</head>

<body>

<div class="container d-flex justify-content-center align-items-center h-100">

    <div class="card login-card" style="width: 400px;">

        <!-- HEADER -->
        <div class="login-header">
            <h4>PDAM TIRTA ALBANTANI CIJERUK LOGIN</h4>
            <small>Sistem Pengaduan Pelanggan</small>
        </div>

        <!-- BODY -->
        <div class="card-body p-4">

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- EMAIL -->
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <!-- PASSWORD -->
                <div class="mb-3">
                    <label class="form-label">Password</label>

                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-control" required>

                        <span class="input-group-text eye-btn" onclick="togglePassword()">
                            <i id="eyeIcon" class="bi bi-eye"></i>
                        </span>
                    </div>
                </div>

                <!-- REMEMBER -->
                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" name="remember">
                    <label class="form-check-label">Ingat saya</label>
                </div>

                <!-- BUTTON -->
                <button class="btn btn-login w-100">
                    Login
                </button>

            </form>

        </div>

    </div>

</div>

<!-- SCRIPT -->
<script>
function togglePassword() {
    const password = document.getElementById("password");
    const icon = document.getElementById("eyeIcon");

    if (password.type === "password") {
        password.type = "text";
        icon.classList.remove("bi-eye");
        icon.classList.add("bi-eye-slash");
    } else {
        password.type = "password";
        icon.classList.remove("bi-eye-slash");
        icon.classList.add("bi-eye");
    }
}
</script>

</body>
</html>
