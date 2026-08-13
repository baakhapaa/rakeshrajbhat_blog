<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Stat;

class StatsSeeder extends Seeder
{
    public function run(): void
    {
        $stats = [
            [
                'number' => '58',
                'label' => 'Students Trained',
                'sub_label' => 'AI & ICT Bootcamp',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'number' => '4',
                'label' => 'Days',
                'sub_label' => 'Intensive Bootcamp',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'number' => '2',
                'label' => 'Municipalities',
                'sub_label' => 'Actively Engaged',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'number' => '15+',
                'label' => 'Team Members',
                'sub_label' => 'Passionate Builders',
                'order' => 4,
                'is_active' => true,
            ],
            [
                'number' => '5 Lakh+',
                'label' => 'NPR Budget',
                'sub_label' => 'Invested in Youth',
                'order' => 5,
                'is_active' => true,
            ],
            [
                'number' => '1000+',
                'label' => 'Future Builders',
                'sub_label' => 'And Growing',
                'order' => 6,
                'is_active' => true,
            ],
        ];

        foreach ($stats as $stat) {
            Stat::create($stat);
        }
    }
}