<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    public function run(): void
    {
        PaymentMethod::create(['name' => 'Tunai', 'description' => 'Pembayaran langsung di lokasi', 'is_active' => true]);
        PaymentMethod::create(['name' => 'QRIS', 'description' => 'Pembayaran via QRIS', 'is_active' => true]);
        PaymentMethod::create(['name' => 'Transfer Bank', 'description' => 'BCA / Mandiri', 'is_active' => true]);
    }
}
