# Flowchart Sistem E-Surat

## 1. Flowchart Umum Sistem

```mermaid
graph TD
    Start([Pengguna Akses Sistem]) --> Auth{Sudah Login?}
    Auth -->|Tidak| Login[Halaman Login]
    Login --> CheckCred{Credential Valid?}
    CheckCred -->|Tidak| LoginFail[Login Gagal]
    LoginFail --> Login
    CheckCred -->|Ya| CheckRole{Role User?}

    Auth -->|Ya| CheckRole

    CheckRole -->|Mahasiswa| MahasiswaMenu[Menu Mahasiswa]
    CheckRole -->|Dosen| DosenMenu[Menu Dosen]
    CheckRole -->|Admin/Operator| AdminMenu[Menu Admin/Operator]

    MahasiswaMenu --> MahasiswaAction["1. Ajukan Surat<br/>2. Lihat Status<br/>3. Download Surat"]
    DosenMenu --> DosenAction["1. Lihat Pengajuan<br/>2. Approve/Reject<br/>3. Lihat Histori"]
    AdminMenu --> AdminAction["1. Kelola User<br/>2. Kelola Jenis Surat<br/>3. Input Surat Jadi<br/>4. Lihat Dashboard"]

    MahasiswaAction --> End1([Selesai])
    DosenAction --> End2([Selesai])
    AdminAction --> End3([Selesai])
```

---

## 2. Flowchart Alur Pengajuan Surat (Mahasiswa)

```mermaid
graph TD
    Start([Mahasiswa Login]) --> Menu["Akses Menu<br/>'Meminta Surat'"]
    Menu --> PilihJenis["Pilih Jenis Surat<br/>(dropdown)"]
    PilihJenis --> LihatRequirement["Lihat Persyaratan<br/>(Jenis Berkas)"]
    LihatRequirement --> Upload["Upload Berkas<br/>Pendukung"]
    Upload --> ValidateFile{Validasi File<br/>Berhasil?}

    ValidateFile -->|Tidak| ErrorFile["❌ Error:<br/>- Tipe file tidak sesuai<br/>- Ukuran > max<br/>- File corrupt"]
    ErrorFile --> Upload

    ValidateFile -->|Ya| Preview["Preview Data<br/>Pengajuan"]
    Preview --> Confirm{Konfirmasi<br/>Benar?}

    Confirm -->|Tidak| PilihJenis
    Confirm -->|Ya| Submit["Submit Pengajuan"]

    Submit --> SaveDB["💾 Simpan ke Database<br/>Status: PENDING"]
    SaveDB --> Notif1["📢 Broadcast Event:<br/>- Email ke Mahasiswa<br/>- Email ke Dosen Penanda Tangan<br/>- In-App Notification"]

    Notif1 --> Success["✅ Pengajuan Berhasil<br/>ID: #[ID]<br/>Status: PENDING"]
    Success --> Redirect["Redirect ke Halaman<br/>Histori Pengajuan"]

    Redirect --> End(["Mahasiswa dapat:<br/>- Lihat Status Real-time<br/>- Download Berkas<br/>- Tunggu Approval"])
```

---

## 3. Flowchart Alur Persetujuan Surat (Dosen)

```mermaid
graph TD
    Start([Dosen Login]) --> Menu["Akses Menu<br/>'Pengajuan'"]
    Menu --> ListPending["📋 Lihat Daftar Pengajuan<br/>Status: PENDING"]

    ListPending --> NotifIn["Notifikasi In-App<br/>Ada pengajuan baru"]
    NotifIn --> SelectPengajuan["Pilih Pengajuan<br/>untuk Ditinjau"]

    SelectPengajuan --> ViewDetail["Lihat Detail:<br/>- Data Mahasiswa<br/>- Jenis Surat<br/>- Berkas Pendukung"]
    ViewDetail --> DownloadBerkas["Download Berkas<br/>Pendukung"]
    DownloadBerkas --> Review["🔍 Review Berkas"]

    Review --> Decision{Setuju<br/>Pengajuan?}

    Decision -->|Tolak| Reject["Pilih Alasan Penolakan"]
    Reject --> InputAlasan["Input Keterangan<br/>Penolakan"]
    InputAlasan --> SaveReject["💾 Simpan Status:<br/>REJECTED"]
    SaveReject --> NotifReject["📢 Notifikasi ke Mahasiswa:<br/>Pengajuan ditolak"]
    NotifReject --> EndReject(["Pengajuan Ditolak"])

    Decision -->|Setuju| Approve["Klik Approve"]
    Approve --> UploadTTD["Upload File<br/>Tanda Tangan Digital"]
    UploadTTD --> ValidateTTD{File TTD<br/>Valid?}

    ValidateTTD -->|Tidak| ErrorTTD["❌ File Tidak Valid"]
    ErrorTTD --> UploadTTD

    ValidateTTD -->|Ya| InputKeterangan["📝 Input Keterangan<br/>(Optional)"]
    InputKeterangan --> SubmitApprove["Submit Approval"]

    SubmitApprove --> SaveApprove["💾 Simpan Status:<br/>APPROVED<br/>Simpan File TTD"]
    SaveApprove --> NotifApprove["📢 Notifikasi & Email:<br/>- Ke Mahasiswa<br/>- Ke Admin/Operator<br/>- Broadcast Event"]

    NotifApprove --> EndApprove(["Pengajuan Disetujui<br/>Menunggu Surat Jadi"])
```

---

## 4. Flowchart Alur Pembuatan Surat Jadi (Admin/Operator)

```mermaid
graph TD
    Start([Admin/Operator Login]) --> Menu["Akses Menu<br/>'Surat Jadi'"]
    Menu --> ListApproved["📋 Lihat Daftar Pengajuan<br/>Status: APPROVED"]

    ListApproved --> SelectPengajuan["Pilih Pengajuan<br/>untuk Dibuat Suratnya"]
    SelectPengajuan --> ViewDetailAdmin["Lihat Detail:<br/>- Data Mahasiswa<br/>- Data Dosen Penanda Tangan<br/>- Jenis Surat<br/>- File TTD"]

    ViewDetailAdmin --> CreateSurat["Buat/Siapkan<br/>Surat Final"]
    CreateSurat --> SourceSurat{Sumber Surat?}

    SourceSurat -->|Template| UseTemplate["Gunakan Template<br/>Jenis Surat"]
    UseTemplate --> FillData["Isi Data:<br/>- Nama Mahasiswa<br/>- NIM<br/>- Tujuan Surat<br/>- Tanggal<br/>- Tanda Tangan Digital"]

    SourceSurat -->|Upload Manual| UploadSurat["Upload File Surat<br/>(PDF/Word)"]

    FillData --> GeneratePDF["Generate/Konversi<br/>ke PDF"]
    UploadSurat --> GeneratePDF

    GeneratePDF --> Preview["Preview Surat Jadi"]
    Preview --> Verify{Verifikasi<br/>Data Benar?}

    Verify -->|Tidak| Edit["Edit Surat"]
    Edit --> Preview

    Verify -->|Ya| SaveSurat["💾 Simpan File Surat<br/>ke Storage"]
    SaveSurat --> UpdateStatus["Update Status:<br/>COMPLETED"]

    UpdateStatus --> NotifComplete["📢 Notifikasi:<br/>- Email ke Mahasiswa<br/>- In-App Notification<br/>- Broadcast Event"]

    NotifComplete --> Success["✅ Surat Jadi Tersedia<br/>Mahasiswa dapat download"]
    Success --> End(["Proses Selesai<br/>Mahasiswa menerima Surat Jadi"])
```

---

## 5. Flowchart Status Pengajuan

```mermaid
graph TD
    A["🟡 PENDING<br/>(Menunggu Approval)"] -->|Dosen Approve| B["🟢 APPROVED<br/>(Disetujui Dosen)"]
    A -->|Dosen Reject| C["🔴 REJECTED<br/>(Ditolak Dosen)"]

    B -->|Admin Input Surat| D["🔵 COMPLETED<br/>(Surat Jadi Tersedia)"]

    C -->|Mahasiswa Submit Ulang| A

    D -->|Mahasiswa Download| E["✅ FINISHED<br/>(Selesai)"]

    style A fill:#ffd700
    style B fill:#90EE90
    style C fill:#FF6B6B
    style D fill:#87CEEB
    style E fill:#98D98E
```

---

## 6. Flowchart Navigasi User

```mermaid
graph TD
    Login["🔐 Login Page<br/>Email & Password"]

    Login --> DashboardMahasiswa["📊 Dashboard Mahasiswa"]
    Login --> DashboardDosen["📊 Dashboard Dosen"]
    Login --> DashboardAdmin["📊 Dashboard Admin"]

    DashboardMahasiswa --> Menu1["👤 Menu Mahasiswa"]
    Menu1 --> AjukanSurat["📝 Ajukan Surat"]
    Menu1 --> HistoriPengajuan["📋 Histori Pengajuan"]
    Menu1 --> StatusPengajuan["📈 Lihat Status"]
    Menu1 --> DownloadSurat["⬇️ Download Surat"]

    DashboardDosen --> Menu2["👨‍🏫 Menu Dosen"]
    Menu2 --> LihatPengajuan["📋 Lihat Pengajuan"]
    Menu2 --> ApprovePengajuan["✅ Approve Pengajuan"]
    Menu2 --> RejectPengajuan["❌ Reject Pengajuan"]
    Menu2 --> HistoriDosen["📊 Histori Penandatanganan"]

    DashboardAdmin --> Menu3["⚙️ Menu Admin"]
    Menu3 --> ManajemenUser["👥 Manajemen User"]
    Menu3 --> ManajemenSurat["📄 Manajemen Jenis Surat"]
    Menu3 --> InputSuratJadi["📝 Input Surat Jadi"]
    Menu3 --> Laporan["📊 Lihat Laporan"]
```

---

## 7. Flowchart Sistem Notifikasi

```mermaid
graph TD
    Event["🔔 Event Terjadi"]

    Event --> EventType{Jenis Event?}

    EventType -->|Pengajuan Dibuat| E1["Event:<br/>PengajuanCreated"]
    EventType -->|Status Berubah| E2["Event:<br/>PengajuanStatusUpdated"]

    E1 --> Broadcast1["📢 Broadcasting"]
    E2 --> Broadcast2["📢 Broadcasting"]

    Broadcast1 --> Channel1["🔗 Channel:<br/>pengajuan.mahasiswa.{id}"]
    Broadcast2 --> Channel2["🔗 Channel:<br/>pengajuan.{id}"]

    Channel1 --> Queue1["📨 Queue Job:<br/>SendNotificationMail"]
    Channel2 --> Queue2["📨 Queue Job:<br/>SendNotificationMail"]

    Queue1 --> InApp1["📱 In-App Notification<br/>(Real-time via WebSocket)"]
    Queue1 --> Email1["✉️ Email Notification"]

    Queue2 --> InApp2["📱 In-App Notification"]
    Queue2 --> Email2["✉️ Email Notification"]

    InApp1 --> User1["👤 User Menerima"]
    Email1 --> User1
    InApp2 --> User2["👤 User Menerima"]
    Email2 --> User2
```

---

## 8. Flowchart Sistem Database

```mermaid
graph TB
    Users["👥 Users Table<br/>- id, name, email<br/>- password, timestamps"]

    Pengajuan["📋 Pengajuan Table<br/>- id, user_id (FK)<br/>- jenis_surat_id (FK)<br/>- berkas (file path)<br/>- status, timestamps"]

    JenisSurat["📄 Jenis_Surat Table<br/>- id, nama_surat<br/>- deskripsi, timestamps"]

    PengajuanTTD["✍️ Pengajuan_TTD Table<br/>- id, pengajuan_id (FK)<br/>- user_id/dosen_id (FK)<br/>- file_ttd, keterangan<br/>- status, timestamps"]

    Roles["🎭 Roles Table<br/>- id, name<br/>(mahasiswa, dosen, admin)"]

    Permissions["🔐 Permissions Table<br/>- id, name<br/>(create, read, update, delete)"]

    RoleHasPermissions["🔗 Role_Has_Permissions<br/>- role_id, permission_id"]

    ModelHasRoles["🔗 Model_Has_Roles<br/>- model_id, role_id"]

    Users -->|has many| Pengajuan
    Users -->|has many| PengajuanTTD
    Users -->|has many| Roles

    JenisSurat -->|has many| Pengajuan

    Pengajuan -->|has many| PengajuanTTD

    Roles -->|has many| Permissions
    Permissions -->|has many| Roles
    Roles -->|has many| Users

    RoleHasPermissions -->|belongs to| Roles
    RoleHasPermissions -->|belongs to| Permissions

    ModelHasRoles -->|belongs to| Users
    ModelHasRoles -->|belongs to| Roles
```

---

## 9. Flowchart Validasi File Upload

```mermaid
graph TD
    Start["File Upload"] --> CheckExist{File Exist?}

    CheckExist -->|Tidak| Error1["❌ File tidak ditemukan"]
    Error1 --> End1["Upload Gagal"]

    CheckExist -->|Ya| CheckMime["Cek MIME Type"]
    CheckMime --> AllowedMime{MIME Type<br/>Allowed?}

    AllowedMime -->|Tidak| Error2["❌ Tipe file tidak diizinkan<br/>(Hanya PDF, DOC, DOCX)"]
    Error2 --> End1

    AllowedMime -->|Ya| CheckSize["Cek Ukuran File"]
    CheckSize --> AllowedSize{Size<br/>≤ Max Size?}

    AllowedSize -->|Tidak| Error3["❌ Ukuran file terlalu besar<br/>(Max: 5MB)"]
    Error3 --> End1

    AllowedSize -->|Ya| Scan["🛡️ Scan Virus/Malware"]
    Scan --> Safe{File Aman?}

    Safe -->|Tidak| Error4["❌ File terdeteksi malware"]
    Error4 --> End1

    Safe -->|Ya| Save["💾 Simpan File<br/>ke Storage"]
    Save --> Success["✅ Upload Berhasil"]
    Success --> End2["File Siap Digunakan"]
```

---

## 10. Flowchart Autentikasi & Otorisasi

```mermaid
graph TD
    Start["User Request"] --> CheckToken{Token Valid?}

    CheckToken -->|Tidak| Error1["❌ Unauthorized<br/>Redirect: Login"]
    Error1 --> LoginPage["Login Page"]
    LoginPage --> End1["Login"]

    CheckToken -->|Ya| CheckRole{Role Sesuai?}

    CheckRole -->|Tidak| Error2["❌ Forbidden<br/>Akses Ditolak"]
    Error2 --> End2["Access Denied"]

    CheckRole -->|Ya| CheckPermission{Permission OK?}

    CheckPermission -->|Tidak| Error3["❌ Forbidden<br/>Permission Denied"]
    Error3 --> End2

    CheckPermission -->|Ya| AllowAccess["✅ Allow<br/>Access Granted"]
    AllowAccess --> ProcessRequest["Proses Request"]
    ProcessRequest --> Response["Return Response"]
    Response --> End3["Success"]

    style Error1 fill:#FF6B6B
    style Error2 fill:#FF6B6B
    style Error3 fill:#FF6B6B
    style AllowAccess fill:#90EE90
```

---

## Deskripsi Singkat Alur Sistem

### 📝 **Fase Pengajuan (Mahasiswa)**

1. Mahasiswa login dan memilih jenis surat
2. Upload berkas pendukung dengan validasi ketat
3. Submit pengajuan yang akan disimpan dengan status **PENDING**
4. Sistem mengirim notifikasi ke dosen dan admin

### ✅ **Fase Persetujuan (Dosen)**

1. Dosen menerima notifikasi pengajuan baru
2. Dosen review berkas dan data mahasiswa
3. Dosen dapat **APPROVE** atau **REJECT**
4. Jika approve, upload file tanda tangan digital
5. Sistem notifikasi otomatis ke mahasiswa dan admin

### 📄 **Fase Pembuatan Surat Jadi (Admin/Operator)**

1. Admin melihat pengajuan yang sudah di-approve
2. Admin membuat/upload surat final
3. Admin verifikasi dan finalisasi surat
4. Status berubah menjadi **COMPLETED**
5. Mahasiswa dapat download surat jadi

### 🔔 **Sistem Notifikasi**

- **Real-time**: WebSocket untuk update in-app
- **Email**: Notifikasi penting dikirim via email
- **Event Broadcasting**: Menggunakan Laravel Event + Queue

### 🔐 **Keamanan**

- RBAC (Role-Based Access Control)
- Permission-based validation
- File upload validation
- CSRF protection
- Password hashing

---

## Status Implementasi

| Fitur             | Status         | Catatan                             |
| ----------------- | -------------- | ----------------------------------- |
| Login/Register    | ✅ Implemented | RBAC, permission-based              |
| Pengajuan Surat   | ✅ Implemented | File upload, real-time notification |
| Persetujuan Dosen | ✅ Implemented | TTD digital, notes                  |
| Surat Jadi        | ✅ Implemented | Upload file, status tracking        |
| Real-time Update  | ✅ Implemented | WebSocket/Reverb                    |
| Email Notifikasi  | ⚠️ Partial     | Queue job ready                     |
| Audit Log         | ❌ Not Yet     | Can be added                        |
| Export Laporan    | ❌ Not Yet     | Can use Excel library               |

---

**Generated**: 2026-06-04 | **Version**: 1.0
