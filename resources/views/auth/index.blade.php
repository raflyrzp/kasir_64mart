<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - 64 Mart</title>

    <link rel="shortcut icon" href="{{ asset('./storage/img/logo/' . $identitas->logo) }}" type="image/x-icon">
    <link rel="stylesheet" href="./assets/compiled/css/app.css">
    <link rel="stylesheet" href="./assets/compiled/css/app-dark.css">
    <link rel="stylesheet" href="./assets/compiled/css/auth.css">
</head>

<body>
    <script src="assets/static/js/initTheme.js"></script>
    <div id="auth">

        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo mb-3">
                        <img src="{{ asset('./storage/img/logo/' . $identitas->logo) }}"
                            style="width: 70px; height: 70px;" alt="Logo">
                    </div>
                    <h1 class="auth-title">Welcome.</h1>
                    <p class="auth-subtitle mb-5">Please login...</p>

                    <form action="" method="POST">
                        @csrf
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" class="form-control form-control-xl" name="username"
                                value="{{ old('username') }}" placeholder="Username">
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" class="form-control form-control-xl" name="password"
                                placeholder="Password">
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5" name="submit"
                            type="submit">Log in</button>
                    </form>
                </div>
            </div>
            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right">
                    <img src="{{ asset('storage/img/background_login/' . $identitas->background_login) }}"
                        style="height: 100vh; width:100%; object-fit:cover; object-position: bottom;">
                </div>
            </div>
        </div>

    </div>
</body>

</html>
