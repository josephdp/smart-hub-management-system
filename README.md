# Smart-Hub Management System 🚀

**Smart-Hub Management System** adalah sistem backend berbasis API yang dirancang untuk mengelola inventaris perangkat pintar dan jadwal peminjaman alat secara otomatis. Sistem ini dibangun menggunakan **Laravel 11** dan dioptimalkan untuk berintegrasi dengan perangkat eksternal seperti aplikasi tablet di lapangan untuk proses *check-in* (pengembalian) yang cepat dan efisien.

Sistem ini dikembangkan sebagai bagian dari pemenuhan tugas Ujian Tengah Semester (UTS) dengan menerapkan praktik pengodean terbaik, manajemen *database* relasional, serta kontrol versi menggunakan strategi *Git Branching*.

---

## ✨ Fitur Utama

* **RESTful API untuk Inventaris:** Menyediakan *endpoint* siap pakai berformat JSON untuk sinkronisasi data alat (`GET /api/equipments`).
* **Sistem Check-In Otomatis:** Memproses pengembalian alat secara *real-time* via tablet lewat metode `PUT /api/check-in/{id}`.
* **Notifikasi Email Otomatis:** Mengirimkan notifikasi email secara instan kepada Admin setiap kali ada pembaruan status peminjaman alat (dikonfigurasi via *Laravel Log Mailer* untuk kebutuhan pengujian).
* **Database Terstruktur & Cascading:** Menggunakan Laravel Migration dengan relasi antar tabel (`users`, `equipments`, `borrowings`) yang aman menggunakan metode `cascadeOnDelete`.
* **Penanganan Masalah Pluralisasi:** Konfigurasi khusus pada model Eloquent untuk menangani anomali bentuk jamak bahasa Inggris (*uncountable nouns*) pada tabel inventaris.

---

## 🛠️ Arsitektur & Teknologi

* **Framework:** Laravel 11 (PHP 8.x)
* **Database:** MySQL / MariaDB (via XAMPP)
* **API Testing:** Postman / Thunder Client
* **Version Control:** Git (Menggunakan strategi *feature branching*)

---

## 🚦 Jalur API (API Endpoints)

| Metode | Endpoint | Fungsi | Status Respons |
| :--- | :--- | :--- | :--- |
| **GET** | `/api/equipments` | Mengambil seluruh daftar inventaris alat | `200 OK` (JSON) |
| **PUT** | `/api/check-in/{id}` | Mengubah status peminjaman menjadi `checked_in` & memicu email | `200 OK` (JSON) |

---

## 💻 Cara Menjalankan Proyek di Lokal

1. **Clone Repositori**
   ```bash
   git clone https://github.com/josephdp/smart-hub-management-system.git
   cd smart-hub-management-system/smart-hub
