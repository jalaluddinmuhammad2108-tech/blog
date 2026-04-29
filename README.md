**UTS Web Programming A**

Nama: Muhammad Jalaluddin

NIM: 240605110235

Project: Sistem Manajemen Blog (CMS)

**Sistem Manajemen Bloc CMS**

Fitur Utama:
1. Kelola Penulis
   - Tambah penulis
   - edit data penulis
   - hapus penulis
   - Uploud foto profil
2. Kelola Artikel
   - Tambah artikel
   - Edit artikel
   - Hapus artikel
   - Uploud gambar artikel
   - relasi dengan penulis dan kategori
3. Kelola kategori
   - Tambah kategori
   - Edit kategori
   - Hapus kategori
**UI/UX yang digunakan:**

- Tampilan modern (dashboard)
- sidebar navigasi
- Modul popup (tambah/edit)
- Notifikasi
- Loading spinner
**Teknologi yang digunakan:**
  
- Frontend: HTML, CSS, JavaScript
- Backend: PHP
- Database: MySQL
- Server: XAMPP

**Struktur Folder:**

Blog/
|

|-index.php

|-koneksi.php

|

|-uploads_penulis/

|-uploads_artikel/

|

|-ambil_penulis.php

|-ambil_satu_penulis.php

|-simpan_penulis.php

|-update_satu_penulis.php

|-hapus_penulis.php

|

|-ambil_artikel.php

|-ambil_satu_artikel.php

|-simpan_artikel.php

|-update_satu_artikel.php

|-hapus_artikel.php

|

|-ambil_kategori.php

|-ambil_satu_kategori.php

|-simpan_kategori.php

|-update_satu_kategori.php

|-hapus_kategori.php

**Struktur Database**
1. Tabel Penulis

id = INT AI (PK)

nama_depan = VARCHAR

nama_belakang = VARCHAR

user_name = VARCHAR

password = VARCHAR

foto = VARCHAR

3. Tabel Kategori
id = INT AI (PK)

nama_kategori = VARCHAR

keterangan = TEXT

5. Tabel artikel
id = INT AI (PK)

judul = VARCHAR

isi = TEXT

gambar = VARCHAR

id_penulis = INT (FK)

id_kategori = INT (FK)

tanggal = DATETIME
