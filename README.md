# Mitra Car Wash (Meruya) — Website demo

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
