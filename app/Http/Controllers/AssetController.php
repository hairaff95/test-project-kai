<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AssetController extends Controller
{
    private function getAssets()
    {
        return [
            [
                'id' => 1,
                'title' => 'Eks Gudang Logistik Kaligawe',
                'address' => 'Jl. Raya Kaligawe Km 5, Genuk, Semarang',
                'lat' => -6.955300,
                'lng' => 110.456100,
                'land_area' => '2,500 m²',
                'building_area' => '1,800 m²',
                'road_access' => 'Kontainer 40ft',
                'price' => 'Rp 12.5 M',
                'status' => 'TERSEDIA',
                'electricity' => '105,000 VA',
                'water' => 'PDAM / Sumur',
                'security' => '24 Jam',
                'description' => 'Gudang logistik premium yang berlokasi strategis di kawasan industri Kaligawe. Memiliki akses langsung ke jalan raya utama yang dapat dilalui oleh kontainer 40ft. Kondisi bangunan sangat terawat dengan spesifikasi lantai heavy-duty, cocok untuk pusat distribusi, penyimpanan barang berat, atau manufaktur ringan. Dekat dengan Pelabuhan Tanjung Emas dan pintu tol Kaligawe.',
                'image' => 'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'id' => 2,
                'title' => 'Eks Rumah Dinas Candisari',
                'address' => 'Jl. Papandayan Raya No. 4A, Candisari, Semarang',
                'lat' => -7.005144,
                'lng' => 110.418423,
                'land_area' => '240 m²',
                'building_area' => '180 m²',
                'road_access' => 'Mobil 2 Arah',
                'price' => 'Rp 1.45 M',
                'status' => 'TERSEDIA',
                'electricity' => '3,500 VA',
                'water' => 'PDAM',
                'security' => 'One Gate System',
                'description' => 'Bangunan eks rumah dinas berarsitektur kokoh di kawasan prestisius Candisari Semarang Atas. Udara sejuk dan lingkungan tenang, sangat cocok untuk dijadikan kantor representatif, café/resto tematik, atau guest house.',
                'image' => 'https://images.unsplash.com/photo-1568605117036-5fe5e7bab0b7?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'id' => 3,
                'title' => 'Lahan Komersial Stasiun Poncol',
                'address' => 'Jl. Imam Bonjol, Semarang Utara, Semarang',
                'lat' => -6.972350,
                'lng' => 110.414920,
                'land_area' => '650 m²',
                'building_area' => '0 m²',
                'road_access' => 'Akses Utama Kota',
                'price' => 'Rp 2.8 M',
                'status' => 'TERSEDIA',
                'electricity' => 'Tersedia Jaringan',
                'water' => 'PDAM',
                'security' => 'Pengamanan Area Stasiun',
                'description' => 'Lahan kosong siap bangun yang berdampingan langsung dengan kawasan Stasiun Semarang Poncol. Traffic pejalan kaki dan penumpang sangat padat setiap hari. Sangat ideal untuk minimarket, pool travel/shuttle, ruko, atau food court modern.',
                'image' => 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?auto=format&fit=crop&w=800&q=80',
            ]
        ];
    }

    public function index()
    {
        $kpi = [
            'total_assets' => 3,
            'total_valuation' => 'Rp 16.75 M',
            'average_age' => '12Y',
        ];

        $assets = $this->getAssets();

        return view('asset-explorer', compact('kpi', 'assets'));
    }

    public function show($id)
    {
        $assets = collect($this->getAssets());
        $asset = $assets->firstWhere('id', (int)$id);

        if (!$asset) {
            abort(404, 'Aset tidak ditemukan');
        }

        return view('asset-detail', compact('asset'));
    }

    public function manage()
    {
        return view('manage-assets');
    }

    public function faq()
    {
        return view('faq');
    }
}