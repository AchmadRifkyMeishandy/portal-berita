# Portal Berita Sepakbola — Development & Learning Roadmap

> Dokumen ini menjadi pedoman utama pengembangan project **Portal Berita Sepakbola** sekaligus pedoman belajar Laravel untuk pemula.
>
> **Aturan utama:** jangan melompat-lompat antar fitur. Selesaikan satu tahap, verifikasi hasilnya, lalu lanjut ke tahap berikutnya.

---

## 1. Tujuan Project

Membangun portal berita sepakbola berbasis Laravel yang terasa seperti aplikasi nyata, bukan sekadar CRUD latihan.

Project akan memiliki dua sisi utama:

### Public Website

- Homepage
- Berita terbaru
- Berita featured
- Breaking news
- Detail artikel
- Kategori
- Tag
- Search
- Related articles
- Author page
- Komentar dan balasan
- Like / bookmark (tahap lanjutan)
- SEO
- Pagination

### Backend CMS

Menggunakan Filament untuk:

- Dashboard
- Article management
- Category management
- Tag management
- User management
- Media management
- Comment moderation
- Workflow artikel
- Role & permission
- Activity log
- Settings (tahap lanjutan)

---

# 2. Tech Stack

- Laravel 12
- PHP 8.3
- MySQL
- Filament 5
- Spatie Laravel Permission
- Blade / Tailwind / Vite
- Laragon
- Git
- GitHub

---

# 3. Prinsip Belajar

Project ini digunakan sebagai **media belajar sambil praktik**.

Jangan hanya mengejar:

> "kode ini jalan."

Targetnya adalah:

> "Saya tahu apa yang dilakukan kode ini, kenapa dibuat seperti ini, kapan biasanya dipakai, apa risikonya, dan bagaimana memperbaikinya."

Setiap pembahasan harus sebisa mungkin menjelaskan:

1. Apa fungsi kode?
2. Bagaimana cara membacanya?
3. Kenapa menggunakan cara tersebut?
4. Kapan biasanya digunakan di dunia kerja?
5. Apa alternatifnya?
6. Apa trade-off / konsekuensinya?
7. Apakah perlu optimasi atau belum?
8. Apakah ada masalah security / maintainability?
9. Bagaimana cara memverifikasi bahwa kode benar-benar bekerja?

---

# 4. Prinsip Code Quality

Gunakan standar yang mendekati praktik industri, tetapi jangan membuat kode lebih rumit dari kebutuhannya.

### Clean Code

- Nama class, method, variable, dan field harus jelas.
- Hindari kode duplikat jika memang ada pola yang jelas.
- Hindari magic number apabila membuat maksud kode sulit dipahami.
- Satu class/method sebaiknya memiliki tanggung jawab yang jelas.
- Jangan membuat abstraction terlalu dini.
- Jangan menambah kompleksitas hanya agar terlihat "professional".
- Pertahankan kode sederhana selama sudah memenuhi kebutuhan.

### Readability

Kode harus mudah dibaca developer lain.

Contoh:

```php
$count(100)
```

lebih sulit dipahami daripada:

```php
$count(self::TOTAL_ARTICLES)
```

jika angka tersebut memang mewakili konsep tertentu.

### Separation of Concerns

Bedakan tanggung jawab:

```text
Model
→ data + relationship

Migration
→ struktur database

Factory
→ bentuk data dummy

Seeder
→ cara data dummy dibuat

Filament Resource
→ penghubung CMS

Form
→ input data

Table
→ tampilan daftar data

Authorization
→ siapa boleh melakukan apa

Business Logic
→ aturan aplikasi
```

Jangan memindahkan semua logic ke satu file hanya karena "lebih cepat".

---

# 5. Prinsip Security

Security dibahas sejak awal, bukan setelah project selesai.

Hal yang harus selalu diperhatikan:

- Validasi input
- Authorization berdasarkan role/permission
- Mass assignment (`fillable`)
- File upload
- SQL injection
- XSS pada content
- CSRF
- Authentication
- Password hashing
- Akses data berdasarkan kepemilikan
- Jangan menyimpan `.env` ke Git
- Jangan menyimpan credential/token di source code

Untuk file upload:

- Batasi tipe file
- Batasi ukuran
- Gunakan storage yang sesuai
- Jangan mempertahankan nama file asli tanpa alasan yang kuat
- Bedakan file yang public dan private

---

# 6. Prinsip Performance

Jangan melakukan optimasi secara berlebihan.

Gunakan prinsip:

> **Measure first, optimize when there is an actual need.**

Urutan belajar performance:

1. Query dasar
2. Lazy loading
3. N+1 Query
4. Eager loading
5. Pagination
6. Select kolom yang diperlukan
7. Index database
8. Query profiling
9. Caching
10. Queue / background job
11. Image optimization
12. Optimasi ketika data benar-benar besar

Jangan menganggap:

- `with()` selalu wajib
- `cache()` selalu lebih cepat
- semua kolom harus dibatasi
- semua query harus dioptimalkan

Kita harus memahami **kapan optimasi berguna dan kapan tidak diperlukan**.

---

# 7. Prinsip Debugging

Saat terjadi error, jangan langsung mengganti banyak hal sekaligus.

Gunakan pola:

```text
Error
  ↓
Buat hipotesis
  ↓
Ubah satu hal
  ↓
Test
  ↓
Amati hasil
  ↓
Persempit penyebab
  ↓
Perbaiki
  ↓
Verifikasi
```

Tujuan debugging bukan hanya membuat error hilang, tetapi mengetahui:

> **kenapa error tersebut terjadi.**

---

# 8. Git Workflow

`main` dianggap sebagai branch yang relatif stabil.

Pengembangan fitur dilakukan melalui feature branch.

Contoh:

```text
main
  ↓
feature/article-cms
  ↓
coding
  ↓
testing
  ↓
commit
  ↓
push
  ↓
review
  ↓
merge ke main
```

Contoh command:

```bash
git switch main
git pull
git switch -c feature/nama-fitur
```

Setelah selesai:

```bash
git status
git add .
git commit -m "feat: ..."
git push -u origin feature/nama-fitur
```

Commit message harus menjelaskan perubahan.

Contoh:

```text
feat: add article categories
fix: prevent invalid article author
refactor: simplify article seeder
docs: update development roadmap
```

---

# 9. Code Review Workflow

Setiap milestone besar sebaiknya direview sebelum lanjut.

Checklist review:

### Functionality

- Apakah fitur bekerja?
- Apakah edge case dipikirkan?

### Clean Code

- Apakah naming jelas?
- Ada kode duplikat?
- Ada magic number?
- Ada abstraction yang belum perlu?

### Security

- Apakah input divalidasi?
- Apakah authorization benar?
- Apakah user bisa mengubah data yang seharusnya tidak boleh?

### Performance

- Apakah ada N+1?
- Apakah query mengambil data terlalu banyak?
- Apakah pagination dibutuhkan?

### Maintainability

- Apakah developer lain bisa memahami kode?
- Apakah perubahan berikutnya akan mudah dilakukan?

---

# 10. Arsitektur Data Saat Ini

## User → Article

```text
User
  │
  └── hasMany Articles

Article
  │
  └── belongsTo User
```

Foreign key:

```text
articles.author_id → users.id
```

## Article ↔ Category

Many-to-many:

```text
Article
   ↕
article_category
   ↕
Category
```

## Article ↔ Tag

Many-to-many:

```text
Article
   ↕
article_tag
   ↕
Tag
```

---

# 11. Role Saat Ini

Role yang sudah dibuat:

- `super_admin`
- `editor`
- `journalist`
- `reader`

Permission utama:

- `articles.view`
- `articles.create`
- `articles.update`
- `articles.delete`
- `articles.review`
- `articles.publish`
- `categories.manage`
- `tags.manage`
- `comments.view`
- `comments.moderate`
- `comments.delete`
- `users.view`
- `users.create`
- `users.update`
- `users.delete`
- `media.view`
- `media.upload`
- `media.delete`

---

# 12. Article Status

Artikel menggunakan empat status:

- `draft`: Artikel sedang ditulis atau perlu diperbaiki.
- `review`: Artikel menunggu pemeriksaan Editor.
- `approved`: Editor sudah menyetujui artikel.
- `published`: Artikel sudah diterbitkan.

Workflow utama:

Journalist creates draft
↓
Submit for Review
↓
review
├── Return for Revision → draft
└── Approve Article → approved
↓
Publish Article
↓
published

Aturan tanggal publikasi:

- `draft`, `review`, dan `approved`: `published_at` bernilai null.
- `published`: `published_at` berisi tanggal dan waktu publikasi.

Catatan revisi:

- `revision_notes` menyimpan catatan Editor.
- Catatan wajib diisi ketika artikel dikembalikan.
- Catatan lama dihapus ketika artikel berhasil dikirim ulang.

# 13. Database / Seeder Checkpoint

Data dummy sudah diverifikasi:

```text
100 artikel
```

Status:

```text
60 published
25 draft
15 review
```

Author:

```text
Andi Pratama  → 34
Budi Santoso  → 28
Citra Lestari → 38
```

Relationship:

```text
2 category / article
4 tag / article
```

---

# 14. Performance Checkpoint yang Sudah Dipelajari

Sudah dibuktikan menggunakan query log:

### Tanpa eager loading

```text
101 query
```

Pola:

```text
1 query articles
+
100 query author
=
101
```

### Eager loading author

```php
Article::with('author')->get();
```

Hasil:

```text
2 query
```

### Eager loading author + categories + tags

```php
Article::with([
    'author',
    'categories',
    'tags',
])->get();
```

Hasil:

```text
4 query
```

Pelajaran:

> Jangan hanya menghafal `with()`. Pahami masalah N+1 dan ukur query yang benar-benar terjadi.

---

# 15. Roadmap Pengembangan — URUTAN WAJIB

## Phase 0 — Fondasi

Status: **SELESAI**

- Laravel setup
- MySQL connection
- Filament installation
- Spatie Permission
- Git / GitHub
- Basic models
- Migrations
- Relationships
- Factories
- Seeders

---

## Phase 1 — Test Data

Status: **SELESAI**

- 100 articles
- Random journalist
- Categories
- Tags
- Article statuses
- Verification through Tinker

---

## Phase 2 — Performance Fundamentals

Status: **SELESAI**

- Query log
- Lazy loading
- N+1 Query
- Eager loading
- Relationship query analysis

Catatan:

> Jangan mengulang optimasi ini terus-menerus. Konsep sudah dibuktikan. Kita kembali saat fitur nyata membutuhkan optimasi.

---

## Phase 3 — Article CMS

Status: **SEDANG DIKERJAKAN**

Urutan di dalam phase ini:

### 3.1 Article Form

- Author
- Category
- Tag
- Title
- Slug
- Excerpt
- Content editor
- Featured image
- SEO fields
- Selesai

### 3.2 Business Rules

- Status workflow
- Draft
- Review
- Published
- `published_at`
- Selesai untuk workflow utama

### 3.3 Authorization

- Journalist
- Editor
- Admin
- Ownership artikel
- Permission publish/review/update/delete
- Selesai untuk aturan utama yang sudah diuji

### 3.4 Article Table

- Kolom penting
- Search
- Filter
- Sorting
- Status badge
- Image
- Actions
- Pagination
- sedang di kerjakan

### 3.5 Article Lifecycle

- Create
- Edit
- Submit review
- Approve
- Publish
- Return/reject
- Delete
- Restore
- Belum dimulai

**Catatan penting:** bagian di atas dikerjakan satu per satu. Jangan mengerjakan semua sekaligus.

---

## Phase 4 — Media

- Featured image
- Storage
- Image validation
- Crop
- Image optimization
- Media management

---

## Phase 5 — Public Frontend

- Homepage
- Article detail
- Category page
- Tag page
- Author page
- Search
- Pagination
- Related articles

---

## Phase 6 — Comments

- Comment model
- Replies
- Moderation
- Anti-spam basics
- Authorization

---

## Phase 7 — SEO

- Meta title
- Meta description
- Canonical URL
- Open Graph
- Sitemap
- Robots
- Structured data

---

## Phase 8 — Advanced Performance

Dilakukan setelah fitur nyata tersedia.

- Database indexes
- Query profiling
- Pagination strategy
- Caching
- Route/cache optimization
- Image optimization
- Queue
- Lazy/eager loading strategy

---

## Phase 9 — Testing

- Feature tests
- Unit tests
- Authorization tests
- Validation tests
- Critical workflow tests

---

## Phase 10 — Production Readiness

- Environment configuration
- Security review
- Error handling
- Logging
- Queue
- Cache
- Backup
- Deployment
- Monitoring

---

# 16. CURRENT CHECKPOINT

**Posisi kita saat ini:**

```text
Phase 3 — Article CMS
        ↓
Article Form
        ↓
Author ✅
Category ✅
Tag ✅
Content editor ✅
Featured image ✅
        ↓
NEXT:
Status Workflow + Authorization
```

**Jangan lompat ke Table / Frontend / Cache sebelum bagian ini selesai**, kecuali ada alasan teknis yang memang diperlukan.

---

# 17. Current Article Form

Sudah berhasil:

```text
Author
→ hanya journalist

Categories
→ many-to-many

Tags
→ many-to-many

Content
→ RichEditor

Featured Image
→ image validation
→ max 5 MB
→ public disk
→ articles directory
→ crop / 16:9
```

Database artikel juga sudah menyimpan featured image dengan benar.

---

# 18. NEXT STEP — STATUS WORKFLOW + AUTHORIZATION

Ini adalah langkah berikutnya yang harus dikerjakan.

Urutan belajarnya:

```text
1. Kenapa status tidak boleh TextInput bebas?
2. Definisi business rule status
3. Role vs permission
4. Journalist vs Editor vs Admin
5. Ownership artikel
6. Authorization di Filament
7. Membatasi field berdasarkan role
8. Publish hanya untuk role yang berhak
9. Submit review
10. Testing workflow
```

Setelah seluruh bagian ini selesai dan diverifikasi:

```text
Status Workflow ✅
Authorization ✅
Testing ✅
```

barulah kita pindah ke:

```text
Article Table
```

---

# 19. Aturan agar pembelajaran tidak lompat-lompat

### Rule 1

**Satu milestone selesai → verifikasi → baru lanjut.**

### Rule 2

Jangan memberikan 100% kode final terlalu cepat.

Lebih baik:

```text
jelaskan konsep
→ contoh kecil
→ praktik
→ test
→ review
→ rapikan
```

### Rule 3

Setiap syntax baru harus dijelaskan dengan bahasa sederhana.

### Rule 4

Setiap konsep penting diberi:

> **Insight Dunia Kerja**

yang menjelaskan kapan konsep tersebut biasanya dipakai.

### Rule 5

Jangan mengubah code hanya karena "bisa dibuat lebih canggih".

Pertanyakan:

> Apakah ada kebutuhan nyata?

### Rule 6

Performance harus berdasarkan pengukuran.

### Rule 7

Security harus dipikirkan sebelum fitur dianggap selesai.

### Rule 8

Jika muncul error:

> pahami error → isolasi penyebab → perbaiki → verifikasi.

### Rule 9

Jangan memodifikasi migration yang sudah pernah dijalankan jika perubahan schema seharusnya dibuat lewat migration baru.

### Rule 10

Sebelum commit:

```text
git status
→ review perubahan
→ test
→ commit
```

---

# 20. Gaya Pengajaran

Penjelasan menggunakan:

- Bahasa Indonesia sederhana
- Istilah teknis tetap disebut dan dijelaskan
- Contoh dunia nyata
- Analogi bila membantu
- Pembahasan baris demi baris untuk kode baru
- Tidak menganggap pengguna sudah mahir Laravel
- Tidak melompat ke konsep advanced sebelum fondasinya siap

Target akhirnya:

> Pengguna mampu membaca, memahami, menulis, melakukan debugging, melakukan code review, dan menjelaskan kembali kode Laravel yang dibuatnya sendiri.

---

# 21. Prinsip Akhir

Project ini bukan lomba menyelesaikan fitur secepat mungkin.

Targetnya adalah membentuk kebiasaan developer:

```text
Understand
   ↓
Design
   ↓
Implement
   ↓
Test
   ↓
Review
   ↓
Refactor
   ↓
Measure
   ↓
Secure
   ↓
Ship
```

Dan setiap kali ada fitur baru, selalu tanyakan:

> **Apa masalah yang ingin diselesaikan?**
>
> **Kenapa desain ini dipilih?**
>
> **Apa risiko atau trade-off-nya?**
>
> **Bagaimana kita membuktikan bahwa implementasinya benar?**
>
