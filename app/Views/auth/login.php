<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Puihaha Electric</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea, #764ba2);
        }

        .login-card {
            max-width: 420px;
            margin: 8vh auto;
            border: 0;
            border-radius: 15px;
        }

        .brand {
            color: #667eea;
            font-weight: 700;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card shadow login-card">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <h2 class="brand">⚡ Puihaha Electric</h2>
                    <p class="text-muted mb-0">Customer Account Management System</p>
                </div>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger">
                        <?= esc(session()->getFlashdata('error')) ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success">
                        <?= esc(session()->getFlashdata('success')) ?>
                    </div>
                <?php endif; ?>

                <form method="post" action="<?= base_url('login') ?>">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" name="username"
                               value="<?= old('username') ?>" required autofocus>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        Log In
                    </button>
                </form>

                <div class="alert alert-info mt-4 mb-0 small">
                    Demo login: <strong>admin</strong> / <strong>admin123</strong>
                </div>
            </div>
        </div>
    </div>
</body>
</html>