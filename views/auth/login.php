<?php require_once __DIR__ . '/templates/header.php'; ?>

<div class="login-wrapper">
    <div class="card login-card" style="box-shadow: 0 10px 25px rgba(0,0,0,0.1); border-radius: 12px; padding: 30px;">
        
        <div class="login-header" style="text-align: center; margin-bottom: 25px;">
            <h2 style="color: var(--primary-color); margin-bottom: 5px;">
                <i class="fa-solid fa-toolbox" style="margin-right: 8px;"></i>SIMPEL Alat
            </h2>
            <p style="color: var(--text-muted); font-size: 14px;">Silakan login untuk melanjutkan</p>
        </div>

        <?php if(!empty($error)): ?>
            <div class="alert-error" style="background-color: #fee2e2; color: #b91c1c; padding: 10px 15px; border-radius: 6px; margin-bottom: 20px; font-size: 14px; border-left: 4px solid #ef4444;">
                <i class="fa-solid fa-triangle-exclamation" style="margin-right: 5px;"></i> <?= $error; ?>
            </div>
        <?php endif; ?>

        <form action="index.php?c=auth&a=login" method="POST">
            <div class="form-group">
                <label for="username">
                    <i class="fa-solid fa-user" style="color: var(--text-muted); margin-right: 5px;"></i> Username
                </label>
                <input type="text" id="username" name="username" class="form-control" value="<?= isset($old_username) ? htmlspecialchars($old_username) : ''; ?>" required autocomplete="off" autofocus placeholder="Masukkan username...">
            </div>
            
            <div class="form-group" style="margin-top: 15px;">
                <label for="password">
                    <i class="fa-solid fa-lock" style="color: var(--text-muted); margin-right: 5px;"></i> Password
                </label>
                <input type="password" id="password" name="password" class="form-control" value="<?= isset($old_password) ? htmlspecialchars($old_password) : ''; ?>" required placeholder="Masukkan password...">
            </div>
            
            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 25px; padding: 12px; font-size: 16px; font-weight: bold;">
                <i class="fa-solid fa-right-to-bracket" style="margin-right: 5px;"></i> Masuk
            </button>
            
            <div style="text-align: center; margin-top: 20px; padding-top: 15px; font-size: 14px; color: var(--text-muted); border-top: 1px solid var(--border-color);">
                Belum punya akun? <br>
                <a href="index.php?c=auth&a=register" style="color: var(--primary-color); text-decoration: none; font-weight: 600; display: inline-block; margin-top: 8px;">
                    <i class="fa-solid fa-user-plus" style="margin-right: 5px;"></i> Daftar sebagai Peminjam
                </a>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/templates/footer.php'; ?>