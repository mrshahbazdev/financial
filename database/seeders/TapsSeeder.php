<?php

namespace Database\Seeders;

use App\Models\Tap;
use Illuminate\Database\Seeder;

class TapsSeeder extends Seeder
{
    public function run(): void
    {
        $industries = [
            [
                'industry' => 'General Business',
                'profit' => 5,
                'owner_pay' => 50,
                'tax' => 15,
                'opex' => 30,
            ],
            [
                'industry' => 'Retail',
                'profit' => 10,
                'owner_pay' => 45,
                'tax' => 15,
                'opex' => 30,
            ],
            [
                'industry' => 'Service',
                'profit' => 15,
                'owner_pay' => 50,
                'tax' => 15,
                'opex' => 20,
            ],
            [
                'industry' => 'Real Estate',
                'profit' => 10,
                'owner_pay' => 40,
                'tax' => 15,
                'opex' => 35,
            ]
        ];

        foreach ($industries as $data) {
            Tap::create($data);
        }
    }
}
