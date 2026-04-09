# 🛠️ SIMPEL ALAT (Sistem Peminjaman Alat)

**SIMPEL ALAT** adalah aplikasi berbasis web yang dirancang untuk mengelola sirkulasi peminjaman dan pengembalian barang/alat (inventaris) di lingkungan sekolah atau instansi.

Aplikasi ini dibangun menggunakan arsitektur **MVC (Model-View-Controller)** dengan pendekatan **OOP (Object-Oriented Programming)** menggunakan **PHP Native dan PDO (PHP Data Objects)**. Aplikasi ini dirancang khusus untuk memenuhi standar ketat Uji Kompetensi Keahlian (UKK) Rekayasa Perangkat Lunak (RPL).

## 🏗️ Arsitektur & Struktur Direktori (MVC)

Aplikasi ini memisahkan logika _Database_ (Model), Antarmuka (View), dan Pengendali Alur (Controller) secara ketat.

## TRIGGER DATABASE

```sql

BEGIN
    UPDATE alat
    SET stok = stok - NEW.jumlah
    WHERE id_alat = NEW.id_alat;
END

```

```sql

BEGIN
    -- Menambah stok kembali berdasarkan detail peminjaman yang direlasikan
    UPDATE alat a
    JOIN detail_peminjaman dp ON a.id_alat = dp.id_alat
    SET a.stok = a.stok + dp.jumlah
    WHERE dp.id_peminjaman = NEW.id_peminjaman;
END

```

```text
📦simpel-alat
 ┣ 📂assets
 ┃ ┣ 📂css
   ┗ 📜style.css
 ┣ 📂config
 ┃ ┗ 📜database.php
 ┣ 📂controllers
 ┃ ┣ 📜AdminController.php
 ┃ ┣ 📜AuthController.php
 ┃ ┣ 📜PeminjamController.php
 ┃ ┗ 📜PetugasController.php
 ┣ 📂models
 ┃ ┣ 📜Alat.php
 ┃ ┣ 📜Kategori.php
 ┃ ┣ 📜Peminjaman.php
 ┃ ┗ 📜User.php
 ┣ 📂views
 ┃ ┣ 📂admin
   ┃ ┣ 📂alat
     ┃ ┣ 📜form.php
     ┃ ┣ 📜index.php
   ┃ ┣ 📂kategori
     ┃ ┣ 📜form.php
     ┃ ┣ 📜index.php
   ┃ ┣ 📂peminjaman
     ┃ ┣ 📜detail.php
     ┃ ┣ 📜index.php
   ┃ ┣ 📂templates
     ┃ ┣ 📜footer.php
     ┃ ┣ 📜header.php
   ┃ ┣ 📂user
     ┃ ┣ 📜form.php
     ┃ ┣ 📜index.php
   ┃ ┣ 📜dashboard.php
 ┃ ┣ 📂auth
   ┃ ┣ 📂templates
     ┃ ┣ 📜footer.php
     ┃ ┣ 📜header.php
   ┃ ┣ 📜login.php
   ┃ ┣ 📜register.php
 ┃ ┣ 📂components
     ┃ ┣ 📜alert.php
     ┃ ┣ 📜confirm.php
 ┃ ┣ 📂peminjam
   ┃ ┣ 📂templates
     ┃ ┣ 📜footer.php
     ┃ ┣ 📜header.php
   ┃ ┣ 📜dashboard.php
   ┃ ┣ 📜keranjang.php
   ┃ ┣ 📜riwayat.php
 ┃ ┗ 📂petugas
   ┃ ┣ 📂templates
     ┃ ┣ 📜footer.php
     ┃ ┣ 📜header.php
   ┃ ┣ 📜dashboard.php
   ┃ ┣ 📜detail.php
   ┃ ┣ 📜laporan.php
 ┣ 📜index.php
 ┗ 📜README.md
```
