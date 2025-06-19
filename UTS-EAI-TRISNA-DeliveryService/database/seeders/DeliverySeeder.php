<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Delivery;
use Carbon\Carbon;

class DeliverySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus data lama untuk menghindari duplikasi saat seeder dijalankan ulang
        Delivery::truncate();

        Delivery::insert([
            [
                'order_id' => 1, // Mengacu pada order Trisna Fitri
                'nama_pelanggan' => 'Trisna Fitri',
                'alamat_pengiriman' => 'Surabaya',
                'kurir' => 'JNE',
                'status_pengiriman' => 'Dikirim',
                'nomor_resi' => 'JNE0012345678',
                'estimasi_tiba' => Carbon::now()->addDays(3)->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => 2, // Mengacu pada order Nasywa Ivena
                'nama_pelanggan' => 'Nasywa Ivena',
                'alamat_pengiriman' => 'Dukuh Kupang',
                'kurir' => 'J&T',
                'status_pengiriman' => 'Tiba',
                'nomor_resi' => 'JTEXPRESS98765',
                'estimasi_tiba' => Carbon::now()->subDay()->toDateString(), // Anggap saja sudah tiba kemarin
                'created_at' => now()->subDays(4),
                'updated_at' => now()->subDay(),
            ],
            [
                // [MODIFIKASI] Data ini tidak lagi memiliki nilai null
                'order_id' => 3, // Mengacu pada order Marista Adelia
                'nama_pelanggan' => 'Marista Adelia',
                'alamat_pengiriman' => 'Ketintang',
                'kurir' => 'Sicepat',
                'status_pengiriman' => 'Dalam Proses Penjemputan', // Status baru yang lebih deskriptif
                'nomor_resi' => 'SC-FAST-003344',
                'estimasi_tiba' => Carbon::now()->addDays(4)->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
