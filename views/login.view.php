<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>MPC | HRIS - Login</title>
    <link href="<?= BASE_URL ?>/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>/assets/css/auth.css" rel="stylesheet">
</head>
<body>
    <div class="wrapper">
        <div class="auth-content">
            <div class="card">
                <div class="card-body text-center">
                    <div class="mb-4">
                        <img class="brand" src="<?= BASE_URL ?>/assets/img/bootstraper-logo.png" alt="bootstraper logo">
                    </div>
                    <h6 class="mb-4 text-muted">Login to your account</h6>
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger text-start">
                            <ul class="mb-0">
                                <?php foreach ($errors as $error): ?>
                                    <li><?= htmlspecialchars($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <form action="<?= BASE_URL ?>/login" method="POST">
                        <div class="mb-3 text-start">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter Email" required>
                        </div>
                        <div class="mb-3 text-start">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                        </div>
                        <button class="btn btn-primary shadow-2 mb-4">Login</button>
                    </form>
                    <p class="mb-0 text-muted">
                        Don't have an account yet? <a href="<?= BASE_URL ?>/signup">Sign Up</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <script src="<?= BASE_URL ?>/assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?= BASE_URL ?>/assets/vendor/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
