<?php require_once __DIR__ . '/templates/header.php'; ?>

<div class="auth-wrapper">
    <div class="card auth-card" style="box-shadow: 0 10px 25px rgba(0,0,0,0.1); border-radius: 12px; padding: 30px; max-width: 450px; margin: 0 auto;">
        
        <div class="auth-header" style="text-align: center; margin-bottom: 25px;">
            <h2 style="color: var(--primary-color); margin-bottom: 5px;">
                <i class="fa-solid fa-user-plus" style="margin-right: 8px;"></i>Daftar Akun Baru
            </h2>
            <p style="color: var(--text-muted); font-size: 14px;">Lengkapi data diri Anda sebagai Peminjam</p>
        </div>

        <?php if(!empty($error)): ?>
            <div class="alert-error" style="background-color: #fee2e2; color: #b91c1c; padding: 10px 15px; border-radius: 6px; margin-bottom: 20px; font-size: 14px; border-left: 4px solid #ef4444;">
                <i class="fa-solid fa-triangle-exclamation" style="margin-right: 5px;"></i> <?= $error; ?>
            </div>
        <?php endif; ?>

        <?php if(!empty($success)): ?>
            <div class="alert-success" style="background-color: #dcfce3; color: #166534; padding: 10px 15px; border-radius: 6px; margin-bottom: 20px; font-size: 14px; border-left: 4px solid #22c55e;">
                <i class="fa-solid fa-circle-check" style="margin-right: 5px;"></i> <?= $success; ?>
            </div>
        <?php endif; ?>

        <form action="index.php?c=auth&a=register" method="POST">
            <div class="form-group">
                <label for="nama_lengkap">
                    <i class="fa-regular fa-id-card" style="color: var(--text-muted); margin-right: 5px;"></i> Nama Lengkap
                </label>
                <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control" required autocomplete="off" autofocus placeholder="Contoh: Budi Santoso">
            </div>

            <div class="form-group" style="margin-top: 15px;">
                <label for="username">
                    <i class="fa-solid fa-user" style="color: var(--text-muted); margin-right: 5px;"></i> Username
                </label>
                <input type="text" id="username" name="username" class="form-control" required autocomplete="off" placeholder="Buat username baru...">
            </div>
            
            <div class="form-group" style="margin-top: 15px;">
                <label for="password">
                    <i class="fa-solid fa-lock" style="color: var(--text-muted); margin-right: 5px;"></i> Password
                </label>
                <input type="password" id="password" name="password" class="form-control" required placeholder="Buat kata sandi yang kuat...">
            </div>
            
            <button type="submit" class="btn btn-success" style="width: 100%; margin-top: 25px; padding: 12px; font-size: 16px; font-weight: bold;">
                <i class="fa-solid fa-paper-plane" style="margin-right: 5px;"></i> Daftar Sekarang
            </button>
            
            <div style="text-align: center; margin-top: 20px; padding-top: 15px; font-size: 14px; color: var(--text-muted); border-top: 1px solid var(--border-color);">
                Sudah punya akun? <br>
                <a href="index.php?c=auth&a=login" style="color: var(--primary-color); text-decoration: none; font-weight: 600; display: inline-block; margin-top: 8px;">
                    <i class="fa-solid fa-right-to-bracket" style="margin-right: 5px;"></i> Login di sini
                </a>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/templates/footer.php'; ?>