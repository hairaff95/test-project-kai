<?php

namespace Database\Seeders;

use App\Models\Asset;
use App\Models\AssetImage;
use Illuminate\Database\Seeder;

class AssetSeeder extends Seeder
{
    public function run(): void
    {
        $assets = [
            [
                'asset_code'    => 'KAI-SMG-001',
                'name'          => 'Eks Gudang Logistik Kaligawe',
                'district_area' => 'Genuk - Semarang Timur',
                'full_address'  => 'Jl. Raya Kaligawe Km 5, Genuk, Semarang',
                'description'   => 'Gudang logistik premium yang berlokasi strategis di kawasan industri Kaligawe. Memiliki akses langsung ke jalan raya utama yang dapat dilalui oleh kontainer 40ft. Kondisi bangunan sangat terawat dengan spesifikasi lantai heavy-duty, cocok untuk pusat distribusi, penyimpanan barang berat, atau manufaktur ringan. Dekat dengan Pelabuhan Tanjung Emas dan pintu tol Kaligawe.',
                'land_area'     => 2500.00,
                'building_area' => 1800.00,
                'price'         => 12500000000.00,
                'road_access'   => 'Kontainer 40ft',
                'electricity'   => '105.000 VA',
                'water_supply'  => 'PDAM / Sumur',
                'security'      => '24 Jam',
                'contact_person'=> 'Bpk. Arif Santoso',
                'contact_phone' => '024-76541000',
                'latitude'      => -6.9553000,
                'longitude'     => 110.4561000,
                'status'        => 'available',
                'gallery'       => [
                    [
                        'url'   => 'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&w=1200&q=80',
                        'title' => 'Area Pergudangan Utama',
                        'primary' => true,
                    ],
                    [
                        'url'   => 'https://images.unsplash.com/photo-1553413077-190dd305871c?auto=format&fit=crop&w=800&q=80',
                        'title' => 'Interior & Ruang Rak Heavy Duty',
                        'primary' => false,
                    ],
                    [
                        'url'   => 'https://images.unsplash.com/photo-1578575437130-527eed3abbec?auto=format&fit=crop&w=800&q=80',
                        'title' => 'Akses Loading Dock Kontainer',
                        'primary' => false,
                    ],
                    [
                        'url'   => 'https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=800&q=80',
                        'title' => 'Ruang Kantor Administrasi',
                        'primary' => false,
                    ],
                    [
                        'url'   => 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?auto=format&fit=crop&w=800&q=80',
                        'title' => 'Halaman Parkir & Manuver Truk',
                        'primary' => false,
                    ],
                ],
            ],
            [
                'asset_code'    => 'KAI-SMG-002',
                'name'          => 'Eks Rumah Dinas Candisari',
                'district_area' => 'Candisari - Semarang Atas',
                'full_address'  => 'Jl. Papandayan Raya No. 4A, Candisari, Semarang',
                'description'   => 'Bangunan eks rumah dinas berarsitektur kokoh di kawasan prestisius Candisari Semarang Atas. Udara sejuk dan lingkungan tenang, sangat cocok untuk dijadikan kantor representatif, café/resto tematik, atau guest house.',
                'land_area'     => 240.00,
                'building_area' => 180.00,
                'price'         => 1450000000.00,
                'road_access'   => 'Mobil 2 Arah',
                'electricity'   => '3.500 VA',
                'water_supply'  => 'PDAM',
                'security'      => 'One Gate System',
                'contact_person'=> 'Ibu Dewi Rahayu',
                'contact_phone' => '024-76541001',
                'latitude'      => -7.0051440,
                'longitude'     => 110.4184230,
                'status'        => 'available',
                'gallery'       => [
                    [
                        'url'   => 'https://images.unsplash.com/photo-1568605117036-5fe5e7bab0b7?auto=format&fit=crop&w=1200&q=80',
                        'title' => 'Tampak Depan Bangunan Heritage',
                        'primary' => true,
                    ],
                    [
                        'url'   => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=800&q=80',
                        'title' => 'Ruang Tamu & Area Komersial Utama',
                        'primary' => false,
                    ],
                    [
                        'url'   => 'https://images.unsplash.com/photo-1600565193348-f74bd3c7ccdf?auto=format&fit=crop&w=800&q=80',
                        'title' => 'Area Ruang Kerja / Pantry',
                        'primary' => false,
                    ],
                    [
                        'url'   => 'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=800&q=80',
                        'title' => 'Halaman Samping & Taman Asri',
                        'primary' => false,
                    ],
                ],
            ],
            [
                'asset_code'    => 'KAI-SMG-003',
                'name'          => 'Lahan Komersial Stasiun Poncol',
                'district_area' => 'Semarang Utara',
                'full_address'  => 'Jl. Imam Bonjol, Semarang Utara, Semarang',
                'description'   => 'Lahan kosong siap bangun yang berdampingan langsung dengan kawasan Stasiun Semarang Poncol. Traffic pejalan kaki dan penumpang sangat padat setiap hari. Sangat ideal untuk minimarket, pool travel/shuttle, ruko, atau food court modern.',
                'land_area'     => 650.00,
                'building_area' => 0.00,
                'price'         => 2800000000.00,
                'road_access'   => 'Akses Utama Kota',
                'electricity'   => 'Tersedia Jaringan',
                'water_supply'  => 'PDAM',
                'security'      => 'Pengamanan Area Stasiun',
                'contact_person'=> 'Bpk. Hendra Wijaya',
                'contact_phone' => '024-76541002',
                'latitude'      => -6.9723500,
                'longitude'     => 110.4149200,
                'status'        => 'available',
                'gallery'       => [
                    [
                        'url'   => 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?auto=format&fit=crop&w=1200&q=80',
                        'title' => 'Kavling Lahan Komersial Utama',
                        'primary' => true,
                    ],
                    [
                        'url'   => 'https://images.unsplash.com/photo-1541888946425-d0fbb18086f6?auto=format&fit=crop&w=800&q=80',
                        'title' => 'Akses Jalan Raya Imam Bonjol',
                        'primary' => false,
                    ],
                    [
                        'url'   => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=800&q=80',
                        'title' => 'Kawasan Sekitar Stasiun Poncol',
                        'primary' => false,
                    ],
                ],
            ],
        ];

        foreach ($assets as $data) {
            $gallery = $data['gallery'];
            unset($data['gallery']);

            $asset = Asset::updateOrCreate(
                ['asset_code' => $data['asset_code']],
                $data
            );

            // Clear old images for this asset
            AssetImage::where('asset_id', $asset->id)->delete();

            foreach ($gallery as $img) {
                AssetImage::create([
                    'asset_id'   => $asset->id,
                    'image_path' => $img['url'],
                    'caption'    => $img['title'] ?? 'Foto Properti',
                    'is_primary' => $img['primary'] ?? false,
                ]);
            }
        }
    }
}
