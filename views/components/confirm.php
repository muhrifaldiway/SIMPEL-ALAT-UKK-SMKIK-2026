<div class="swal-overlay" id="customConfirm">
    <div class="swal-modal">
        <div class="swal-icon warning">!</div>
        
        <h3 class="swal-title" id="confirmTitle">Konfirmasi</h3>
        <p class="swal-text" id="confirmText">Apakah Anda yakin ingin melanjutkan?</p>
        
        <div class="swal-actions">
            <button class="swal-btn cancel" onclick="closeConfirm()">Batal</button>
            <a href="#" id="btnConfirmAction" class="swal-btn error">Ya, Lanjutkan!</a>
        </div>
    </div>
</div>

<script>
    function showConfirm(url, itemName = '', actionType = 'delete') {
        var titleEl = document.getElementById('confirmTitle');
        var textEl = document.getElementById('confirmText');
        var btnEl = document.getElementById('btnConfirmAction');
        
        // 1. Jika tombol Logout
        if (actionType === 'logout') {
            titleEl.innerText = "Konfirmasi Keluar";
            textEl.innerText = "Apakah Anda yakin ingin keluar dari aplikasi?";
            btnEl.innerText = "Ya, Keluar!";
            btnEl.style.backgroundColor = "#f59e0b"; // Oranye
        } 
        // 2. Jika tombol Setujui Peminjaman
        else if (actionType === 'approve') {
            titleEl.innerText = "Konfirmasi Persetujuan";
            textEl.innerText = "Apakah Anda yakin ingin menyetujui pengajuan peminjaman ini?";
            btnEl.innerText = "Ya, Setujui!";
            btnEl.style.backgroundColor = "#10b981"; // Hijau
        }
        // 3. Jika tombol Tolak Peminjaman
        else if (actionType === 'reject') {
            titleEl.innerText = "Konfirmasi Penolakan";
            textEl.innerText = "Apakah Anda yakin ingin menolak pengajuan peminjaman ini?";
            btnEl.innerText = "Ya, Tolak!";
            btnEl.style.backgroundColor = "#ef4444"; // Merah
        }
        // 4. Jika tombol Terima Pengembalian
        else if (actionType === 'return') {
            titleEl.innerText = "Konfirmasi Pengembalian";
            textEl.innerText = "Apakah alat sudah dikembalikan oleh siswa dengan kondisi baik?";
            btnEl.innerText = "Ya, Terima Alat!";
            btnEl.style.backgroundColor = "#8b5cf6"; // Ungu
        }
        // 5. Default (Tombol Hapus Data)
        else {
            titleEl.innerText = "Konfirmasi Hapus";
            textEl.innerText = "Apakah Anda yakin ingin menghapus '" + itemName + "'? Tindakan ini tidak dapat dibatalkan.";
            btnEl.innerText = "Ya, Hapus!";
            btnEl.style.backgroundColor = "#ef4444"; // Merah
        }
        
        // Pasang URL tujuan ke tombol aksi
        btnEl.href = url;
        
        // Tampilkan modal
        document.getElementById('customConfirm').classList.add('show');
    }

    function closeConfirm() {
        document.getElementById('customConfirm').classList.remove('show');
    }
</script>
