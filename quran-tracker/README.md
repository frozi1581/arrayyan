# Quran Tracker

Aplikasi web mobile-friendly untuk manajemen hafalan dan murajaah Quran menggunakan Laravel dan Blade.

## Fitur Utama

### 🔐 Autentikasi
- Login menggunakan email dan password
- Login dengan Google OAuth
- Sistem registrasi pengguna

### 👥 Manajemen Group
- Buat dan kelola group santri
- Sistem kode unik untuk bergabung dengan group
- Role admin dan member dalam group

### 👨‍🎓 Profil Santri
- Buat dan kelola profil santri
- Upload foto profil
- Informasi lengkap santri (nama, email, telepon, alamat, dll)

### 📖 Hafalan Baru
- Tambah target hafalan baru
- Set target tanggal penyelesaian
- Status tracking (pending, completed, reviewed)
- Sistem skor dan feedback dari ustadz

### 🔄 Murajaah
- Tambah jadwal murajaah
- Pengulangan hafalan yang sudah dipelajari
- Tracking progress murajaah

### 📊 Dashboard
- Overview progress mingguan
- Tugas hari ini
- Statistik pencapaian
- Quick actions untuk akses cepat

### 📱 Mobile-Friendly
- Responsive design untuk semua device
- Bootstrap 5 untuk UI yang modern
- Touch-friendly interface

## Teknologi yang Digunakan

- **Backend**: Laravel 12.x
- **Frontend**: Blade Templates + Bootstrap 5
- **Database**: MySQL/MariaDB
- **Authentication**: Laravel Auth + Socialite (Google OAuth)
- **Icons**: Font Awesome 6
- **JavaScript**: jQuery

## Instalasi

### Prerequisites
- PHP 8.1+
- Composer
- MySQL/MariaDB
- Node.js & NPM (untuk asset compilation)

### Langkah Instalasi

1. **Clone Repository**
   ```bash
   git clone <repository-url>
   cd quran-tracker
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database Configuration**
   Edit file `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=quran_tracker
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

5. **Google OAuth Setup**
   Tambahkan ke file `.env`:
   ```env
   GOOGLE_CLIENT_ID=your_google_client_id
   GOOGLE_CLIENT_SECRET=your_google_client_secret
   GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
   ```

6. **Database Migration**
   ```bash
   php artisan migrate
   php artisan storage:link
   ```

7. **Run Application**
   ```bash
   php artisan serve
   ```

   Aplikasi akan berjalan di `http://localhost:8000`

## Struktur Database

### Tabel Utama
- `users` - Data pengguna
- `groups` - Data group santri
- `santris` - Profil santri
- `group_members` - Relasi group dan santri
- `hafalans` - Data hafalan baru
- `murajaahs` - Data murajaah

### Relasi
- User → Santri (1:1)
- Group → GroupMember (1:N)
- Santri → GroupMember (1:N)
- Santri → Hafalan (1:N)
- Santri → Murajaah (1:N)
- Group → Hafalan (1:N)
- Group → Murajaah (1:N)

## Fitur Admin

### Manajemen Group
- Buat group baru
- Kelola anggota group
- Generate kode join group
- Edit informasi group

### Manajemen Santri
- Lihat profil semua santri
- Edit informasi santri
- Aktifkan/nonaktifkan santri

### Monitoring Progress
- Lihat progress hafalan semua santri
- Berikan skor dan feedback
- Review hafalan yang sudah selesai

## API Endpoints

### Authentication
- `GET /login` - Halaman login
- `POST /login` - Proses login
- `GET /auth/google` - Redirect ke Google OAuth
- `GET /auth/google/callback` - Callback Google OAuth

### Groups
- `GET /groups` - List groups
- `POST /groups` - Buat group baru
- `GET /groups/{id}` - Detail group
- `PUT /groups/{id}` - Update group
- `DELETE /groups/{id}` - Hapus group
- `POST /groups/{id}/join` - Join group
- `POST /groups/{id}/leave` - Leave group

### Santris
- `GET /santris` - Profil santri
- `POST /santris` - Buat profil santri
- `PUT /santris/{id}` - Update profil
- `DELETE /santris/{id}` - Hapus profil

### Hafalans
- `GET /hafalans` - List hafalan
- `POST /hafalans` - Tambah hafalan
- `GET /hafalans/{id}` - Detail hafalan
- `PUT /hafalans/{id}` - Update hafalan
- `DELETE /hafalans/{id}` - Hapus hafalan
- `POST /hafalans/{id}/complete` - Mark selesai

### Murajaahs
- `GET /murajaahs` - List murajaah
- `POST /murajaahs` - Tambah murajaah
- `GET /murajaahs/{id}` - Detail murajaah
- `PUT /murajaahs/{id}` - Update murajaah
- `DELETE /murajaahs/{id}` - Hapus murajaah
- `POST /murajaahs/{id}/complete` - Mark selesai

## Konfigurasi Google OAuth

1. Buka [Google Cloud Console](https://console.cloud.google.com/)
2. Buat project baru atau pilih project yang ada
3. Aktifkan Google+ API
4. Buat OAuth 2.0 credentials
5. Tambahkan authorized redirect URI: `http://localhost:8000/auth/google/callback`
6. Copy Client ID dan Client Secret ke file `.env`

## Deployment

### Production Setup
1. Set `APP_ENV=production` di `.env`
2. Set `APP_DEBUG=false` di `.env`
3. Optimize aplikasi:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```
4. Setup web server (Apache/Nginx)
5. Setup SSL certificate
6. Update Google OAuth redirect URI ke domain production

## Contributing

1. Fork repository
2. Buat feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

## License

Distributed under the MIT License. See `LICENSE` for more information.

## Support

Untuk pertanyaan atau bantuan, silakan buat issue di repository ini.

## Screenshots

### Dashboard
![Dashboard](screenshots/dashboard.png)

### Mobile View
![Mobile](screenshots/mobile.png)

### Hafalan Management
![Hafalan](screenshots/hafalan.png)

### Group Management
![Groups](screenshots/groups.png)