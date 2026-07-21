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

## 💻 Cara Menjalankan Proyek di Lokal

Karena aplikasi ini mengusung arsitektur terpisah, Anda harus menjalankan *Backend* dan *Frontend* di dua terminal yang berbeda.

### 1. Clone Repositori
```bash
git clone [https://github.com/josephdp/smart-hub-management-system.git](https://github.com/josephdp/smart-hub-management-system.git)
cd smart-hub-management-system
