<p align="center">
    <img src="https://wkm-ind.co.id/wp-content/uploads/2024/07/Wahana-Kendali-Mutu-2.png" width="400" alt="Wahana Kendali Mutu Logo">
</p>

<p align="center">
    <a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
    <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
    <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
    <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Sistem Pendaftaran Workshop & Event - PT Wahana Kendali Mutu

Sistem pendaftaran workshop dan event yang dibangun khusus untuk PT Wahana Kendali Mutu. Platform ini memungkinkan peserta untuk mendaftar workshop, mengelola pembayaran, dan mengikuti berbagai acara yang diselenggarakan oleh perusahaan.

## 📋 Tentang Sistem

PT Wahana Kendali Mutu adalah perusahaan yang fokus pada pelatihan dan pengembangan sumber daya manusia di bidang kendali mutu. Sistem ini dikembangkan untuk:

-   **Manajemen Workshop**: Mengelola berbagai workshop dan pelatihan
-   **Pendaftaran Peserta**: Sistem pendaftaran yang mudah dan intuitif
-   **Pembayaran Online**: Integrasi sistem pembayaran dengan kalkulasi PPN otomatis
-   **Manajemen Peserta**: Tracking dan monitoring peserta workshop
-   **Laporan & Analytics**: Dashboard admin untuk monitoring kegiatan

## ✨ Fitur Utama

### 🎯 Untuk Peserta

-   **Pendaftaran Workshop**: Interface yang user-friendly untuk mendaftar workshop
-   **Multi-Participant**: Mendaftarkan beberapa peserta sekaligus dalam satu transaksi
-   **Real-time Payment Calculation**: Kalkulasi biaya otomatis termasuk PPN 11%
-   **Form Validation**: Validasi form yang komprehensif
-   **Responsive Design**: Dapat diakses dari berbagai perangkat

### 👨‍💼 Untuk Administrator

-   **Dashboard Admin**: Panel administrasi menggunakan Filament
-   **Workshop Management**: CRUD workshop dan event
-   **Participant Management**: Kelola data peserta dan pendaftaran
-   **Payment Tracking**: Monitor status pembayaran
-   **Reports & Analytics**: Laporan lengkap tentang kegiatan workshop

### 🔧 Fitur Teknis

-   **Unsaved Data Protection**: Peringatan saat meninggalkan halaman dengan data belum tersimpan
-   **Dynamic Form Generation**: Form peserta yang dapat ditambah/kurangi secara dinamis
-   **Auto-calculation**: Perhitungan total biaya otomatis
-   **Data Validation**: Validasi client-side dan server-side

## 🛠️ Teknologi yang Digunakan

### Backend

-   **Laravel 11**: Framework PHP modern
-   **PHP 8.2+**: Bahasa pemrograman utama
-   **MySQL/SQLite**: Database management
-   **Filament**: Admin panel framework

### Frontend

-   **Blade Templates**: Template engine Laravel
-   **Tailwind CSS**: Utility-first CSS framework
-   **JavaScript (Vanilla)**: Interaktivitas frontend
-   **Vite**: Build tool dan bundler

### Tools & Dependencies

-   **Composer**: PHP dependency manager
-   **NPM**: Node.js package manager
-   **Git**: Version control system

## 📦 Struktur Proyek

```
wkm-project/
├── app/
│   ├── Filament/           # Admin panel configuration
│   ├── Http/              # Controllers dan Middleware
│   ├── Models/            # Eloquent models
│   ├── Providers/         # Service providers
│   ├── Repositories/      # Repository pattern
│   └── Services/          # Business logic services
├── config/                # Configuration files
├── database/
│   ├── factories/         # Model factories
│   ├── migrations/        # Database migrations
│   └── seeders/          # Database seeders
├── public/
│   └── js/
│       └── booking.js     # Frontend booking logic
├── resources/
│   └── views/
│       └── front/
│           └── index.blade.php  # Homepage
├── routes/               # Route definitions
├── storage/             # File storage
└── tests/               # Unit & feature tests
```

## 🚀 Instalasi & Setup

### Prasyarat

-   PHP 8.2 atau lebih tinggi
-   Composer
-   Node.js & NPM
-   MySQL/SQLite
-   Git

### Langkah Instalasi

1. **Clone Repository**

    ```bash
    git clone https://github.com/your-username/wkm-project.git
    cd wkm-project
    ```

2. **Install Dependencies**

    ```bash
    # Install PHP dependencies
    composer install

    # Install Node.js dependencies
    npm install
    ```

3. **Environment Setup**

    ```bash
    # Copy environment file
    cp .env.example .env

    # Generate application key
    php artisan key:generate
    ```

4. **Database Configuration**

    ```bash
    # Edit .env file dengan konfigurasi database
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=wkm_database
    DB_USERNAME=your_username
    DB_PASSWORD=your_password
    ```

5. **Database Migration & Seeding**

    ```bash
    # Run migrations
    php artisan migrate

    # Run seeders (optional)
    php artisan db:seed
    ```

6. **Build Assets**

    ```bash
    # Development
    npm run dev

    # Production
    npm run build
    ```

7. **Start Development Server**

    ```bash
    php artisan serve
    ```

    Akses aplikasi di `http://localhost:8000`

## 🔧 Konfigurasi

### Environment Variables

Sesuaikan file `.env` dengan kebutuhan:

```env
APP_NAME="WKM Workshop System"
APP_ENV=local
APP_KEY=base64:generated_key
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=wkm_database
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### Admin Panel

Akses admin panel di `/admin` setelah membuat user admin:

```bash
php artisan make:filament-user
```

## 📖 Penggunaan

### Pendaftaran Workshop

1. Kunjungi halaman utama sistem
2. Pilih workshop yang diinginkan
3. Tentukan jumlah peserta menggunakan tombol increment/decrement
4. Isi data peserta pada form yang tersedia
5. Review total pembayaran (termasuk PPN 11%)
6. Submit form untuk melakukan pendaftaran

### Fitur JavaScript Booking

File [`public/js/booking.js`](public/js/booking.js) mengatur:

-   Dynamic participant forms
-   Real-time price calculation
-   Form validation
-   Payment details update

### Admin Dashboard

Akses `/admin` untuk:

-   Mengelola workshop dan event
-   Melihat daftar pendaftaran
-   Monitor pembayaran
-   Generate laporan

## 🧪 Testing

```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter=WorkshopTest

# Run with coverage
php artisan test --coverage
```

## 📝 API Documentation

### Workshop Endpoints

```
GET /api/workshops          # Get all workshops
GET /api/workshops/{id}     # Get specific workshop
POST /api/workshops         # Create new workshop
PUT /api/workshops/{id}     # Update workshop
DELETE /api/workshops/{id}  # Delete workshop
```

### Registration Endpoints

```
POST /api/registrations     # Create new registration
GET /api/registrations/{id} # Get registration details
PUT /api/registrations/{id} # Update registration
```

## 🤝 Kontribusi

Kami menyambut kontribusi dari developer untuk meningkatkan sistem ini:

1. Fork repository
2. Buat feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

### Coding Standards

-   Ikuti PSR-12 untuk PHP
-   Gunakan conventional commits
-   Tulis tests untuk fitur baru
-   Update dokumentasi sesuai kebutuhan

## 📊 Performance & Monitoring

### Optimization

-   Database indexing untuk query performance
-   Image optimization dan lazy loading
-   CSS/JS minification untuk production
-   Caching strategy untuk data workshop

### Monitoring

-   Laravel Telescope untuk debugging (development)
-   Application logs di `storage/logs/`
-   Database query monitoring
-   Error tracking dan reporting

## 🔒 Keamanan

-   CSRF protection pada semua forms
-   Input validation dan sanitization
-   SQL injection prevention dengan Eloquent ORM
-   XSS protection dengan Blade templating
-   Secure file upload handling

---

**© 2025 PT Wahana Kendali Mutu. All rights reserved.**
