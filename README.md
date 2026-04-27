# Mitra Car Wash (Meruya) — Website demo

Contoh website **PHP + HTML/CSS/JS** untuk **Mitra Car Wash (Meruya)**, dengan tiga varian sesuai paket: **Premium**, **Gold**, dan **Diamond** (profil, layanan & harga, kontak, WhatsApp, dan fitur tambahan per tier).

## Struktur URL (XAMPP)

Letakkan folder project di `htdocs` (mis. `c:\xampp\htdocs\Bisinis`), lalu buka:

| Paket | URL lokal |
|--------|-----------|
| Premium | `http://localhost/Bisinis/premium/` |
| Gold | `http://localhost/Bisinis/gold/` |
| Diamond | `http://localhost/Bisinis/diamond/` |
| Sandbox root (opsional) | `http://localhost/Bisinis/` |

## Fitur ringkas per tier

- **Premium:** Home, About, Services, Contact — Maps, form inquiry, keranjang layanan + checkout via WhatsApp.
- **Gold:** Semua Premium + **Booking**, **Promo**, **admin** sederhana (inquiry & appointment).
- **Diamond:** Semua Gold + **landing campaign**, **blog**, **SEO dasar**, **admin** lebih lengkap (termasuk update status).

## Logo merk mobil (opsional)

Taruh file logo di `assets/brands/` dengan nama slug + ekstensi (mis. `toyota.svg`, `bmw.png`). Lihat `lib/brands.php` untuk aturan penamaan. Tanpa file, UI menampilkan teks merk seperti biasa.

## Admin (Gold & Diamond)

- Gold: `http://localhost/Bisinis/gold/admin/`
- Diamond: `http://localhost/Bisinis/diamond/admin/`

Kredensial default ada di `gold/config.php` dan `diamond/config.php`. **Wajib diganti** sebelum production.

## Push ke GitHub

Repo GitHub contoh: [mitracarwashmeruyademo](https://github.com/Jmedelllu/mitracarwashmeruyademo).

**Setup awal (clone baru atau folder belum ada Git):**

```bash
cd c:\xampp\htdocs\Bisinis
git init
git add .
git commit -m "Initial commit: Mitra Car Wash demo (Premium, Gold, Diamond)"
git branch -M main
git remote add origin https://github.com/Jmedelllu/mitracarwashmeruyademo.git
git push -u origin main
```

**Sudah ada commit lokal, hanya ganti remote:**

```bash
cd c:\xampp\htdocs\Bisinis
git remote set-url origin https://github.com/Jmedelllu/mitracarwashmeruyademo.git
git push -u origin main
```

> Jika di GitHub Anda sudah pernah push README minimal dari folder lain dan riwayatnya beda dengan project ini, push pertama bisa memakai `git push -u origin main --force` (menimpa isi branch `main` di remote). Hati-hati jika remote sudah berisi pekerjaan penting.

Ganti `Jmedelllu` / nama repo jika berbeda. Untuk HTTPS, gunakan **Personal Access Token** sebagai password (bukan password akun), atau pakai **SSH**.

## Catatan keamanan

- File `**/storage/*.json` dan `*.sqlite` diabaikan Git (data lokal). Setelah deploy, data akan terbentuk di server.
- Jangan commit password admin atau token API ke repo publik.
