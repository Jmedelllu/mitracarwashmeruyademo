<?php

declare(strict_types=1);

return [
    // Public site settings
    'site' => [
        'name' => 'Mitra Car Wash (Meruya)',
        'tagline' => 'Cuci mobil & detailing profesional di Meruya',
        'description' => 'Mitra Car Wash (Meruya) adalah bengkel umum yang bisa Anda hubungi atau datangi untuk melakukan service. Anda juga dapat melakukan booking service secara gratis untuk menjadwalkan kedatangan agar terbebas dari antrian di bengkel.',
        'address' => 'Jl. Raden Saleh No.7/25, RT.5/RW.1, Meruya Utara, Kec. Kembangan, Kota Jakarta Barat, DKI Jakarta 11620',
        // Format: 62xxxxxxxxxx (no +, no spaces)
        'whatsapp_number' => '6281290190163',
        // Google Maps embed URL (replace if needed)
        'maps_embed_url' => 'https://www.google.com/maps?q=Jl.%20Raden%20Saleh%20No.7%2F25%2C%20Meruya%20Utara%2C%20Jakarta%20Barat%2011620&output=embed',
        'hours' => [
            'Senin' => '07.30 - 20.00',
            'Selasa' => '07.30 - 20.00',
            'Rabu' => '07.30 - 20.00',
            'Kamis' => '07.30 - 20.00',
            'Jumat' => '07.30 - 20.00',
            'Sabtu' => '07.30 - 20.00',
            'Minggu' => '07.30 - 20.00',
        ],
        'facilities' => [
            'Ruang Tunggu AC',
            'Tempat Ibadah',
            'Coffee Shop',
            'Free WiFi',
        ],
        'images' => [
            'montiro_1' => '/Bisinis/assets/img/montiro-1.png',
            'montiro_2' => '/Bisinis/assets/img/montiro-2.png',
        ],
        'services_catalog' => [
            ['name' => 'Car Wash', 'price' => 55000],
            ['name' => 'Detailing', 'price' => 1200000],
            ['name' => 'Salon Mobil', 'price' => 500000],
            ['name' => 'Jasa Coating', 'price' => 2490000],
            ['name' => 'Jasa Pemasangan Anti Karat', 'price' => 350000],
            ['name' => 'Cuci Mobil Kecil', 'price' => 50000],
            ['name' => 'Poles Body', 'price' => 200000],
        ],
        'brands' => [
            'BMW', 'Chevrolet', 'Daihatsu', 'Datsun', 'DFSK', 'Fiat', 'Ford', 'Honda', 'Hyundai',
            'Isuzu', 'Jeep', 'KIA', 'Lexus', 'Mercedes', 'Mini', 'Mitsubishi', 'Nissan', 'Opel',
            'Peugeot', 'Proton', 'Renault', 'Suzuki', 'Timor', 'Toyota', 'Volkswagen', 'Volvo', 'Wuling',
        ],
    ],

    // Storage (SQLite for Diamond demo isolation)
    'storage' => [
        'mode' => 'sqlite',
        'sqlite_path' => __DIR__ . '/storage/diamond.sqlite',
        'inquiries_path' => __DIR__ . '/storage/inquiries.json',
        'appointments_path' => __DIR__ . '/storage/appointments.json',
    ],

    // Very simple admin auth for demo purposes
    'admin' => [
        'username' => 'admin',
        'password' => 'admin123',
        'session_name' => 'bisinis_admin_diamond',
    ],
];

