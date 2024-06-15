Untuk memperbarui README.md agar mencakup informasi tentang penggunaan seeder yang telah ditambahkan, berikut adalah tambahannya:

```markdown
## Instalasi

Ikuti langkah-langkah berikut untuk menyiapkan proyek di mesin lokal Anda.

### Kloning Repositori

1. Buka terminal atau command prompt.
2. Kloning repositori menggunakan perintah berikut:
   ```bash
   git clone https://github.com/itshusni29/Apiforionic.git
   ```
3. Masuk ke direktori proyek:
   ```bash
   cd Apiforionic
   ```

### Instalasi Dependensi

1. Instal dependensi proyek dengan menjalankan:
   ```bash
   composer install
   ```

### Konfigurasi Environment

1. Salin file `.env.example` menjadi `.env`:
   ```bash
   cp .env.example .env
   ```
2. Buka file `.env` dan sesuaikan konfigurasi database Anda:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nama_database
   DB_USERNAME=user_database
   DB_PASSWORD=password_database
   ```
3. Generate application key:
   ```bash
   php artisan key:generate
   ```
4. Generate JWT secret key:
   ```bash
   php artisan jwt:secret
   ```

### Migrasi Database

1. Jalankan migrasi database untuk membuat tabel yang diperlukan:
   ```bash
   php artisan migrate
   ```

### Menambahkan Data Seeder

1. Jalankan seeder untuk memasukkan data dummy pengguna:
   ```bash
   php artisan db:seed --class=UsersTableSeeder
   ```

### Menjalankan Proyek

1. Untuk memulai server pengembangan lokal, jalankan:
   ```bash
   php artisan serve
   ```
2. Perintah ini akan memulai server di `http://localhost:8000`.

## Fitur

### AuthController

Mengelola otentikasi pengguna menggunakan JWT (JSON Web Token):
- `register`: Mendaftarkan pengguna baru.
- `login`: Masuk dengan kredensial pengguna dan menerima token JWT.
- `logout`: Keluar dan menghapus token.
- `refresh`: Memperbarui token yang telah kedaluwarsa.
- `me`: Mendapatkan informasi pengguna yang terotentikasi.

### BookController

Mengelola data buku:
- `index`: Melihat daftar semua buku.
- `show`: Melihat detail buku berdasarkan ID.
- `store`: Menambahkan buku baru.
- `update`: Memperbarui informasi buku.
- `destroy`: Menghapus buku.

### BookLoanController

Mengelola peminjaman buku:
- `index`: Melihat daftar semua peminjaman.
- `store`: Meminjam buku.
- `update`: Memperbarui status peminjaman.
- `destroy`: Mengembalikan buku yang dipinjam.

### BookLoanHistoryController

Menyimpan riwayat peminjaman buku:
- `index`: Melihat riwayat peminjaman buku.
- `show`: Melihat detail riwayat peminjaman berdasarkan ID.

### Controller

Base controller yang digunakan oleh controller lainnya. Ini menyediakan fungsionalitas umum yang dapat digunakan di semua controller.

### RatingsController

Mengelola rating buku:
- `index`: Melihat daftar semua rating.
- `store`: Menambahkan rating baru.
- `update`: Memperbarui rating.
- `destroy`: Menghapus rating.

### UserController

Mengelola data pengguna:
- `index`: Melihat daftar semua pengguna.
- `show`: Melihat detail pengguna berdasarkan ID.
- `update`: Memperbarui informasi pengguna.
- `destroy`: Menghapus pengguna.

### WishlistController

Mengelola wishlist buku pengguna:
- `index`: Melihat daftar semua buku dalam wishlist.
- `store`: Menambahkan buku ke wishlist.
- `destroy`: Menghapus buku dari wishlist.

## Penggunaan

Setelah server berjalan, Anda dapat mengakses API endpoint melalui alat seperti Postman atau melalui aplikasi frontend yang terhubung. Setiap endpoint yang membutuhkan otentikasi harus menyertakan token JWT dalam header permintaan.

## Berkontribusi

Jika Anda ingin berkontribusi pada proyek ini, silakan ikuti langkah-langkah berikut:

1. Fork repositori ini.
2. Buat cabang baru:
   ```bash
   git checkout -b fitur/NamaFiturAnda
   ```
3. Lakukan perubahan Anda.
4. Commit perubahan Anda:
   ```bash
   git commit -m 'Tambahkan beberapa fitur'
   ```
5. Push ke cabang:
   ```bash
   git push origin fitur/NamaFiturAnda
   ```
6. Buat pull request.

## Lisensi

Proyek ini dilisensikan di bawah Lisensi MIT. Lihat file [LICENSE](LICENSE) untuk detail lebih lanjut.

---

Jika Anda mengalami masalah atau memiliki pertanyaan, jangan ragu untuk membuka isu di GitHub. Selamat coding!

Anda dapat menyimpan konten ini dalam file bernama `README.md` di direktori proyek Anda.
```

Dengan menambahkan bagian ini, README.md sekarang mencakup langkah-langkah untuk menjalankan seeder dan juga memberikan gambaran umum tentang proyek Apiforionic beserta fitur-fiturnya. Anda dapat menyimpan konten ini dalam file README.md di direktori proyek Anda untuk memberikan panduan yang jelas kepada pengembang yang lain.