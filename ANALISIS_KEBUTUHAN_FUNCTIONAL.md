# Analisis Kebutuhan Functional - Sistem E-Surat

## Daftar Isi

1. [Overview Sistem](#overview-sistem)
2. [Aktor/User](#aktor--user)
3. [Kebutuhan Functional](#kebutuhan-functional)
4. [Detail Functional Requirements](#detail-functional-requirements)
5. [Diagram Alur Proses](#diagram-alur-proses)

---

## Overview Sistem

**Nama Sistem:** E-Surat (Sistem Manajemen Surat Elektronik)  
**Tujuan:** Mengelola proses pengajuan, persetujuan, dan pembuatan surat secara elektronik di lingkungan akademik  
**Platform:** Web-based (Laravel)  
**Target User:** Mahasiswa, Dosen, Admin/Operator

---

## Aktor & User

| No  | Aktor          | Deskripsi                                                | Role             |
| --- | -------------- | -------------------------------------------------------- | ---------------- |
| 1   | Mahasiswa      | Pengajuan surat kepada universitas                       | `mahasiswa`      |
| 2   | Dosen          | Menandatangani/menyetujui pengajuan surat                | `dosen`          |
| 3   | Admin          | Mengelola user, role, permission, dan konfigurasi sistem | `admin`          |
| 4   | Operator/Staff | Membuat/menginput final surat jadi                       | `operator/admin` |

---

## Kebutuhan Functional

### 1. Autentikasi & Otorisasi

| ID      | Kebutuhan                 | Deskripsi                                            | Prioritas | Status      |
| ------- | ------------------------- | ---------------------------------------------------- | --------- | ----------- |
| AUTH.01 | Register User             | User baru dapat mendaftar dengan email dan password  | High      | Implemented |
| AUTH.02 | Login                     | User dapat login dengan email dan password           | High      | Implemented |
| AUTH.03 | Logout                    | User dapat logout dari sistem                        | High      | Implemented |
| AUTH.04 | Role-Based Access Control | Sistem membatasi akses berdasarkan role pengguna     | High      | Implemented |
| AUTH.05 | Permission Management     | Setiap aksi dikontrol dengan permission-based system | High      | Implemented |
| AUTH.06 | Session Management        | Sistem mengelola session pengguna yang login         | High      | Implemented |

### 2. Manajemen User (Admin)

| ID      | Kebutuhan          | Deskripsi                                            | Prioritas | Status          |
| ------- | ------------------ | ---------------------------------------------------- | --------- | --------------- |
| USER.01 | Lihat Daftar User  | Admin dapat melihat semua user di sistem             | High      | Implemented     |
| USER.02 | Buat User Baru     | Admin dapat membuat user baru dengan role tertentu   | High      | Implemented     |
| USER.03 | Edit User          | Admin dapat mengubah data user (nama, email, role)   | High      | Implemented     |
| USER.04 | Hapus User         | Admin dapat menghapus user dari sistem               | High      | Implemented     |
| USER.05 | Assign Role        | Admin dapat memberikan role kepada user              | High      | Implemented     |
| USER.06 | Reset Password     | Admin dapat mereset password user                    | Medium    | Not Implemented |
| USER.07 | Filter/Search User | Admin dapat mencari user berdasarkan nama atau email | Medium    | Not Implemented |

### 3. Manajemen Jenis Surat (Admin)

| ID       | Kebutuhan                     | Deskripsi                                                            | Prioritas | Status          |
| -------- | ----------------------------- | -------------------------------------------------------------------- | --------- | --------------- |
| JENIS.01 | Lihat Daftar Jenis Surat      | Admin dapat melihat semua jenis surat yang tersedia                  | High      | Implemented     |
| JENIS.02 | Buat Jenis Surat              | Admin dapat menambah jenis surat baru                                | High      | Implemented     |
| JENIS.03 | Edit Jenis Surat              | Admin dapat mengubah nama/detail jenis surat                         | High      | Implemented     |
| JENIS.04 | Hapus Jenis Surat             | Admin dapat menghapus jenis surat                                    | Medium    | Not Implemented |
| JENIS.05 | Tentukan Dosen Penanda Tangan | Admin dapat menentukan dosen yang akan menandatangani surat tertentu | Medium    | Not Implemented |

### 4. Pengajuan Surat (Mahasiswa)

| ID           | Kebutuhan                 | Deskripsi                                                                                 | Prioritas | Status                           |
| ------------ | ------------------------- | ----------------------------------------------------------------------------------------- | --------- | -------------------------------- |
| PENGAJUAN.01 | Lihat Form Pengajuan      | Mahasiswa dapat mengakses form untuk meminta surat                                        | High      | Implemented                      |
| PENGAJUAN.02 | Pilih Jenis Surat         | Mahasiswa dapat memilih jenis surat yang diinginkan                                       | High      | Implemented                      |
| PENGAJUAN.03 | Upload Berkas             | Mahasiswa dapat upload berkas pendukung pengajuan                                         | High      | Implemented                      |
| PENGAJUAN.04 | Submit Pengajuan          | Mahasiswa dapat submit pengajuan surat                                                    | High      | Implemented                      |
| PENGAJUAN.05 | Lihat Histori Pengajuan   | Mahasiswa dapat melihat riwayat semua pengajuan yang pernah dibuat                        | High      | Implemented                      |
| PENGAJUAN.06 | Lihat Status Pengajuan    | Mahasiswa dapat melihat status terkini pengajuan (pending, approved, rejected, completed) | High      | Implemented                      |
| PENGAJUAN.07 | Download Berkas Pendukung | Mahasiswa dapat mendownload berkas yang telah diupload                                    | High      | Implemented                      |
| PENGAJUAN.08 | Download Surat Jadi       | Mahasiswa dapat mendownload surat final jika sudah selesai                                | High      | Implemented                      |
| PENGAJUAN.09 | Batas Maksimal Pengajuan  | Sistem membatasi jumlah pengajuan per hari/bulan (jika perlu)                             | Low       | Not Implemented                  |
| PENGAJUAN.10 | Notifikasi Real-time      | Mahasiswa menerima notifikasi update status pengajuan secara real-time                    | High      | Implemented (Via WebSocket/Echo) |

### 5. Persetujuan Surat (Dosen)

| ID             | Kebutuhan                     | Deskripsi                                                             | Prioritas | Status          |
| -------------- | ----------------------------- | --------------------------------------------------------------------- | --------- | --------------- |
| PERSETUJUAN.01 | Lihat Daftar Pengajuan        | Dosen dapat melihat pengajuan yang perlu ditandatangani               | High      | Implemented     |
| PERSETUJUAN.02 | Lihat Detail Pengajuan        | Dosen dapat melihat detail pengajuan (mahasiswa, jenis surat, berkas) | High      | Implemented     |
| PERSETUJUAN.03 | Approve Pengajuan             | Dosen dapat menyetujui pengajuan surat                                | High      | Implemented     |
| PERSETUJUAN.04 | Reject Pengajuan              | Dosen dapat menolak pengajuan dengan alasan                           | Medium    | Not Implemented |
| PERSETUJUAN.05 | Upload File Tanda Tangan      | Dosen dapat upload file tanda tangan digital                          | High      | Implemented     |
| PERSETUJUAN.06 | Lihat Histori Penandatanganan | Dosen dapat melihat riwayat pengajuan yang telah ditandatangani       | Medium    | Not Implemented |
| PERSETUJUAN.07 | Keterangan/Notes              | Dosen dapat menambahkan catatan pada pengajuan                        | High      | Implemented     |

### 6. Pembuatan Surat Jadi (Admin/Operator)

| ID       | Kebutuhan                             | Deskripsi                                                | Prioritas | Status          |
| -------- | ------------------------------------- | -------------------------------------------------------- | --------- | --------------- |
| SURAT.01 | Lihat Daftar Pengajuan yang Disetujui | Admin dapat melihat pengajuan yang sudah disetujui dosen | High      | Implemented     |
| SURAT.02 | Input/Upload Surat Jadi               | Admin dapat menginput/upload file surat jadi             | High      | Implemented     |
| SURAT.03 | Tandai Surat Selesai                  | Admin dapat mengubah status pengajuan menjadi completed  | High      | Implemented     |
| SURAT.04 | Download Surat                        | Admin dapat mendownload surat jadi                       | Medium    | Not Implemented |
| SURAT.05 | Verifikasi Data Surat                 | Admin dapat memverifikasi data surat sebelum finalisasi  | Medium    | Not Implemented |

### 7. Dashboard & Laporan

| ID           | Kebutuhan               | Deskripsi                                                    | Prioritas | Status          |
| ------------ | ----------------------- | ------------------------------------------------------------ | --------- | --------------- |
| DASHBOARD.01 | Dashboard Mahasiswa     | Mahasiswa dapat melihat ringkasan pengajuan mereka           | Medium    | Implemented     |
| DASHBOARD.02 | Dashboard Dosen         | Dosen dapat melihat ringkasan pengajuan yang perlu disetujui | Medium    | Implemented     |
| DASHBOARD.03 | Dashboard Admin         | Admin dapat melihat statistik sistem                         | Medium    | Implemented     |
| DASHBOARD.04 | Laporan Pengajuan       | Admin dapat membuat/export laporan pengajuan                 | Medium    | Not Implemented |
| DASHBOARD.05 | Laporan Penandatanganan | Admin dapat membuat/export laporan penandatanganan           | Medium    | Not Implemented |
| DASHBOARD.06 | Statistik Pengajuan     | Admin dapat melihat statistik pengajuan per bulan/tahun      | Low       | Not Implemented |

### 8. Notifikasi & Komunikasi

| ID       | Kebutuhan                | Deskripsi                                                                       | Prioritas | Status          |
| -------- | ------------------------ | ------------------------------------------------------------------------------- | --------- | --------------- |
| NOTIF.01 | Notifikasi Status Update | Sistem mengirim notifikasi saat status pengajuan berubah                        | High      | Implemented     |
| NOTIF.02 | Email Notifikasi         | Sistem mengirim email notifikasi (optional)                                     | Medium    | Not Implemented |
| NOTIF.03 | In-App Notification      | Sistem menampilkan notifikasi di aplikasi secara real-time                      | High      | Implemented     |
| NOTIF.04 | Pengingat Dosen          | Sistem dapat mengirim pengingat ke dosen tentang pengajuan yang belum disetujui | Low       | Not Implemented |

### 9. Keamanan & Validasi

| ID          | Kebutuhan        | Deskripsi                                            | Prioritas | Status          |
| ----------- | ---------------- | ---------------------------------------------------- | --------- | --------------- |
| SECURITY.01 | Password Hashing | Password user di-hash dan disimpan dengan aman       | High      | Implemented     |
| SECURITY.02 | Input Validation | Semua input dari user divalidasi                     | High      | Implemented     |
| SECURITY.03 | File Validation  | File yang diupload divalidasi (tipe, ukuran)         | High      | Implemented     |
| SECURITY.04 | CSRF Protection  | Sistem dilengkapi CSRF token untuk mencegah serangan | High      | Implemented     |
| SECURITY.05 | Audit Log        | Setiap aksi penting dicatat dalam log                | Medium    | Not Implemented |
| SECURITY.06 | Rate Limiting    | Sistem membatasi request untuk mencegah brute force  | Medium    | Not Implemented |
| SECURITY.07 | Soft Delete      | Data yang dihapus tidak benar-benar hilang           | Low       | Not Implemented |

### 10. Integrasi & API

| ID     | Kebutuhan          | Deskripsi                                                 | Prioritas | Status                   |
| ------ | ------------------ | --------------------------------------------------------- | --------- | ------------------------ |
| API.01 | Real-time Update   | Sistem menggunakan WebSocket untuk update real-time       | High      | Implemented (Via Reverb) |
| API.02 | Event Broadcasting | Event pengajuan di-broadcast ke channel yang relevan      | High      | Implemented              |
| API.03 | API Integration    | Sistem dapat diintegrasikan dengan sistem lain (optional) | Low       | Not Implemented          |

---

## Detail Functional Requirements

### A. Alur Pengajuan Surat (Mahasiswa)

```
1. Mahasiswa login ke sistem
2. Mahasiswa mengakses menu "Meminta Surat"
3. Mahasiswa memilih jenis surat yang diinginkan
4. Mahasiswa mengupload berkas pendukung (jika diperlukan)
5. Mahasiswa submit pengajuan
6. Sistem menyimpan pengajuan dengan status "pending"
7. Mahasiswa dapat melihat pengajuan di "Histori Pengajuan"
8. Mahasiswa dapat melihat update status secara real-time
```

### B. Alur Persetujuan Surat (Dosen)

```
1. Dosen login ke sistem
2. Dosen mengakses menu "Pengajuan" (Dosen)
3. Dosen melihat daftar pengajuan yang perlu disetujui
4. Dosen membuka detail pengajuan
5. Dosen melihat berkas pendukung mahasiswa
6. Dosen dapat:
   - Approve: Upload file TTD, status berubah ke "approved"
   - Reject: Menambahkan alasan penolakan, status berubah ke "rejected"
7. Sistem mengirim notifikasi ke mahasiswa tentang update status
```

### C. Alur Pembuatan Surat Jadi (Admin/Operator)

```
1. Admin/Operator login ke sistem
2. Admin melihat pengajuan yang sudah di-approve dosen
3. Admin membuat/menginput surat final
4. Admin upload file surat jadi (PDF/DOC)
5. Admin submit/finalize surat
6. Sistem mengubah status menjadi "completed"
7. Mahasiswa mendapat notifikasi dan dapat download surat jadi
```

---

## Diagram Alur Proses

### Status Pengajuan

```
┌─────────────┐
│   Pending   │ (Menunggu persetujuan dosen)
└──────┬──────┘
       │
       ├─→ Approved  (Disetujui dosen)  ──→ Complete (Surat jadi selesai)
       │
       └─→ Rejected  (Ditolak dosen)
```

### Struktur Database

```
users
├── id
├── name
├── email
├── password
├── role (via roles table)
└── timestamps

pengajuan
├── id
├── nim (from user)
├── user_id (FK → users)
├── jenis_surat_id (FK → jenis_surat)
├── berkas (file path)
├── status (pending/approved/rejected/completed)
├── file_surat_jadi
└── timestamps

jenis_surat
├── id
├── nama_surat
└── timestamps

pengajuan_ttd
├── id
├── pengajuan_id (FK → pengajuan)
├── user_id (FK → users - dosen)
├── dosen_id (FK → users)
├── file_ttd (signature file)
├── keterangan (notes)
├── status
└── timestamps

model_permissions (Spatie)
├── id
├── name (create.pengajuan, read.pengajuan.ttd, etc)
└── guard_name

model_roles (Spatie)
├── id
├── name (mahasiswa, dosen, admin)
└── guard_name

role_has_permissions
├── role_id
└── permission_id
```

---

## Ringkasan Kebutuhan

| Kategori                | Total    | Implemented | Not Implemented |
| ----------------------- | -------- | ----------- | --------------- |
| Autentikasi & Otorisasi | 6        | 6           | 0               |
| Manajemen User          | 7        | 5           | 2               |
| Manajemen Jenis Surat   | 5        | 2           | 3               |
| Pengajuan Surat         | 10       | 9           | 1               |
| Persetujuan Surat       | 7        | 5           | 2               |
| Pembuatan Surat         | 5        | 3           | 2               |
| Dashboard & Laporan     | 6        | 3           | 3               |
| Notifikasi              | 4        | 2           | 2               |
| Keamanan & Validasi     | 7        | 4           | 3               |
| Integrasi & API         | 3        | 2           | 1               |
| **TOTAL**               | **60**   | **41**      | **19**          |
| **Persentase**          | **100%** | **68%**     | **32%**         |

---

## Rekomendasi

### Fitur Yang Masih Perlu Dikembangkan (Prioritas Tinggi):

1. ✅ **Email Notification** - Mengirim email notifikasi ke user
2. ✅ **Audit Log** - Mencatat setiap aksi penting
3. ✅ **Rejection Flow** - Alur penolakan pengajuan oleh dosen
4. ✅ **Export Laporan** - Fitur export laporan ke Excel/PDF
5. ✅ **Dashboard Analytics** - Statistik dan grafik pengajuan

### Fitur Opsional (Prioritas Rendah):

- Batas pengajuan per periode
- Email reminder untuk dosen
- QR Code untuk verifikasi surat
- Digital signature dengan sertifikat
- Mobile app version

---

**Dokumen ini di-generate pada:** 2026-06-04  
**Versi:** 1.0  
**Status:** Draft
