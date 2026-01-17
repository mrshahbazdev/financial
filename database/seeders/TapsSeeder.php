<?php

namespace Database\Seeders;

use App\Models\Tap;
use Illuminate\Database\Seeder;

class TapsSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing system taps to avoid duplicates if re-seeding
        Tap::whereNull('user_id')->delete();

        $ranges = [
            [
                'label' => 'A',
                'industry' => 'Real Revenue $0 - $250k',
                'min_revenue' => 0,
                'max_revenue' => 250000,
                'profit' => 5,
                'owner_pay' => 50,
                'tax' => 15,
                'opex' => 30,
            ],
            [
                'label' => 'B',
                'industry' => 'Real Revenue $250k - $500k',
                'min_revenue' => 250000,
                'max_revenue' => 500000,
                'profit' => 10,
                'owner_pay' => 35,
                'tax' => 15,
                'opex' => 40,
            ],
            [
                'label' => 'C',
                'industry' => 'Real Revenue $500k - $1M',
                'min_revenue' => 500000,
                'max_revenue' => 1000000,
                'profit' => 15,
                'owner_pay' => 20,
                'tax' => 15,
                'opex' => 50,
            ],
            [
                'label' => 'D',
                'industry' => 'Real Revenue $1M - $5M',
                'min_revenue' => 1000000,
                'max_revenue' => 5000000,
                'profit' => 10,
                'owner_pay' => 10,
                'tax' => 15,
                'opex' => 65,
            ],
            [
                'label' => 'E',
                'industry' => 'Real Revenue $5M - $10M',
                'min_revenue' => 5000000,
                'max_revenue' => 10000000,
                'profit' => 15,
                'owner_pay' => 5,
                'tax' => 15,
                'opex' => 65,
            ],
            [
                'label' => 'F',
                'industry' => 'Real Revenue $10M - $50M',
                'min_revenue' => 10000000,
                'max_revenue' => 50000000,
                'profit' => 17,
                'owner_pay' => 3,
                'tax' => 15,
                'opex' => 65,
            ],
        ];

        foreach ($ranges as $data) {
            Tap::create($data);
        }
    }
}
