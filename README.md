# Smart-Hub Management System 🚀

**Smart-Hub Management System** adalah sistem *Full-Stack* (Web Application & API Backend) yang dirancang untuk mengelola inventaris perangkat pintar dan jadwal peminjaman alat secara otomatis. Sistem ini dibangun menggunakan **Laravel 13** dan antarmuka reaktif **Vue.js (Inertia.js)**, serta dioptimalkan untuk berintegrasi dengan perangkat eksternal seperti aplikasi tablet di lapangan untuk proses *check-in* (pengembalian) yang cepat dan efisien.

Sistem ini dikembangkan dengan menerapkan praktik pengodean terbaik, pemisahan *port* (CORS), manajemen *database* relasional, serta kontrol versi menggunakan strategi *Git Branching*.

---

## ✨ Fitur Utama (Core Development)

* **Autentikasi Aman:** Integrasi halaman *Login* Web dengan API backend menggunakan otorisasi Token (*Bearer Token*) via Laravel Sanctum.
* **Modul Manage Data Master:** Mengelola data inventaris utama dengan fitur *List* (Lihat), *Create* (Tambah), dan *Delete* (Hapus) peralatan.
* **Modul Manage Transaction:** Dasbor operasional peminjaman dengan fitur *List*, *Create*, *Update* status, serta validasi terhadap data *check-in* peralatan yang diinput oleh *user*.
* **Integrasi API (Inertia.js):** Integrasi *seamless* dengan API *backend* menggunakan metode pemanggilan *fetch* standar dalam ekosistem Laravel Inertia.js.
* **Database Terstruktur & Cascading:** Menggunakan Laravel Migration dengan relasi antar tabel (`users`, `equipments`, `transactions`) yang aman menggunakan metode `cascadeOnDelete`.

---

## 🛠️ Arsitektur & Teknologi

* **Backend Framework:** Laravel 13 (PHP 8.x)
* **Frontend Framework:** Vue.js 3, Inertia.js, Tailwind CSS (Breeze)
* **Database:** MySQL / MariaDB (via XAMPP)
* **API Authentication:** Laravel Sanctum
* **Version Control:** Git (Menggunakan strategi *feature branching*)

---

## 🚦 Jalur API (API Endpoints)

| Metode | Endpoint | Fungsi | Keterangan |
| :--- | :--- | :--- | :--- |
| **POST** | `/api/login` | Melakukan login dan *generate Bearer Token* | Akses Publik |
| **GET** | `/api/equipments` | Mengambil seluruh daftar inventaris alat | `auth:sanctum` |
| **POST** | `/api/equipments` | Menambah alat/inventaris baru ke master data | `auth:sanctum` |
| **DELETE** | `/api/equipments/{id}` | Menghapus data alat dari database | `auth:sanctum` |
| **GET** | `/api/transactions` | Mengambil riwayat daftar transaksi peminjaman | `auth:sanctum` |
| **POST** | `/api/transactions` | Membuat catatan transaksi peminjaman baru | `auth:sanctum` |
| **PUT** | `/api/transactions/{id}` | Memperbarui status transaksi | `auth:sanctum` |
| **PUT** | `/api/check-in/{id}` | Validasi dan ubah status peminjaman menjadi `returned` | `auth:sanctum` |

---
FLOW APLIKASI SMART-HUB MANAGEMENT SYSTEM

1. Flow Autentikasi (Login):
Pengguna memasukkan email dan password di halaman Login Frontend (Vue) -> Frontend mengirimkan request POST ke /api/login di Port 8000 -> Backend (Laravel) memvalidasi data dan menerbitkan Bearer Token (Sanctum) -> Frontend menerima respons sukses dan menyimpan token tersebut ke dalam localStorage browser.

2. Flow Master Data (Inventaris):
Pengguna mengakses halaman Master Data -> Frontend mengirimkan request GET/POST/DELETE ke /api/equipments dengan menyertakan Bearer Token di dalam header permintaan -> Backend memvalidasi token melalui middleware auth:sanctum, mengeksekusi perintah ke database, lalu mengembalikan data dalam format JSON -> Frontend menerima JSON dan merender tabel data secara dinamis di layar pengguna.

3. Flow Transaksi & Check-In:
Pengguna membuat transaksi baru atau mengubah status peminjaman di dasbor web -> Frontend mengirim payload data beserta Bearer Token ke endpoint /api/transactions atau /api/check-in/{id} -> Backend memvalidasi otorisasi dan memproses perubahan status di dalam database relasional -> Backend mengembalikan respons sukses -> UI di Frontend memunculkan notifikasi dan otomatis memuat ulang (reload) data transaksi terbaru.

## 💻 Cara Menjalankan Proyek di Lokal

Karena aplikasi ini mengusung arsitektur terpisah, Anda harus menjalankan *Backend* dan *Frontend* di dua terminal yang berbeda.

### 1. Clone Repositori
```bash
git clone [https://github.com/josephdp/smart-hub-management-system.git](https://github.com/josephdp/smart-hub-management-system.git)
cd smart-hub-management-system
