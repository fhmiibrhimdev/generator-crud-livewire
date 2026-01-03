<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Generator CRUD Livewire

Project ini adalah aplikasi web berbasis **Laravel 11** dan **Livewire 3** yang dirancang untuk mempermudah pembuatan dan pengelolaan data (CRUD) dengan antarmuka yang reaktif dan modern. Dilengkapi dengan manajemen role (RBAC) menggunakan Laratrust dan utilitas tambahan seperti Code Beautifier.

## 🚀 Fitur Utama

-   **Autentikasi & Otorisasi**: Sistem login aman dengan pembagian hak akses menggunakan **Laratrust**.
    -   **Admin**: Akses penuh ke modul manajemen (Kategori, Blog, Mahasiswa).
    -   **User**: Akses terbatas sesuai izin.
    -   **Developer**: Akses khusus pengembang.
-   **CRUD Modules**: Contoh implementasi CRUD real-time menggunakan Livewire:
    -   **Kategori**: Manajemen kategori konten.
    -   **Blog**: Manajemen artikel blog.
    -   **Mahasiswa**: Manajemen data mahasiswa.
-   **Code Beautifier**: Tools untuk merapikan kode (HTML & Code snippets).
-   **Profile Management**: Fitur update profil pengguna.
-   **Tech Stack**:
    -   Laravel 11
    -   Livewire 3.5
    -   TailwindCSS (via Vite)
    -   Laratrust 8.3

## 🛠 Persyaratan Sistem

Pastikan server atau lingkungan lokal Anda memiliki:

-   PHP >= 8.2
-   Composer
-   Node.js & NPM
-   Database (MySQL/MariaDB/SQLite)

## 📦 Instalasi

Ikuti langkah-langkah berikut untuk menjalankan project di komputer lokal Anda:

1.  **Clone Repository**

    ```bash
    git clone https://github.com/username/generator-crud-livewire.git
    cd generator-crud-livewire
    ```

2.  **Install Dependensi PHP**

    ```bash
    composer install
    ```

3.  **Install Dependensi Frontend**

    ```bash
    npm install && npm run build
    ```

4.  **Konfigurasi Environment**
    Salin file `.env.example` menjadi `.env`:

    ```bash
    cp .env.example .env
    ```

    Atur konfigurasi database di file `.env`.

5.  **Generate Key Aplikasi**

    ```bash
    php artisan key:generate
    ```

6.  **Migrasi Database & Seeding**
    Jalankan migrasi untuk membuat tabel dan data awal (role/user default):

    ```bash
    php artisan migrate --seed
    ```

7.  **Jalankan Aplikasi**
    ```bash
    php artisan serve
    ```
    Buka `http://localhost:8000` di browser Anda.

## 📝 Penggunaan

Silakan login menggunakan akun yang telah dibuat saat seeding (cek `database/seeders` jika tersedia informasi akun default, biasanya `admin@example.com` / `password`).

## 🤝 Kontribusi

Kontribusi sangat diterima! Silakan fork repository ini lalu buat Pull Request untuk perubahan yang Anda sarankan.

## 📄 Lisensi

Project ini dilisensikan di bawah [MIT license](https://opensource.org/licenses/MIT).
