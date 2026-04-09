<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Aplikasi Peminjaman Alat</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <?php require_once BASE_PATH . '/views/components/confirm.php'; ?>
    <?php require_once BASE_PATH . '/views/components/alert.php'; ?>
    <style>
        /* Tambahan CSS khusus untuk layout halaman login agar ke tengah */
        .login-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-color: var(--bg-color);
        }
        .login-card {
            width: 100%;
            max-width: 400px;
        }
        .login-header {
            text-align: center;
            margin-bottom: 24px;
        }
        .login-header h2 {
            color: var(--primary-color);
            margin-bottom: 8px;
        }
        .alert-error {
            background-color: #fee2e2;
            color: #b91c1c;
            padding: 12px;
            border-radius: var(--radius);
            margin-bottom: 20px;
            font-size: 14px;
            text-align: center;
            border: 1px solid #f87171;
        }

        .auth-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-color: var(--bg-color);
        }
        .auth-card {
            width: 100%;
            max-width: 450px;
        }
        .auth-header {
            text-align: center;
            margin-bottom: 24px;
        }
        .auth-header h2 {
            color: var(--primary-color);
            margin-bottom: 8px;
        }
        .alert-error {
            background-color: #fee2e2;
            color: #b91c1c;
            padding: 12px;
            border-radius: var(--radius);
            margin-bottom: 20px;
            font-size: 14px;
            text-align: center;
            border: 1px solid #f87171;
        }
        .alert-success {
            background-color: #dcfce3;
            color: #166534;
            padding: 12px;
            border-radius: var(--radius);
            margin-bottom: 20px;
            font-size: 14px;
            text-align: center;
            border: 1px solid #86efac;
        }
        .link-text {
            display: block;
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
            color: var(--text-muted);
        }
        .link-text a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
        }
        .link-text a:hover {
            text-decoration: underline;
        }
    </style>
</head>