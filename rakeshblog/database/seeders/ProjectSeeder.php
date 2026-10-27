<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'name' => 'Baakhapaa',
                'slug' => 'baakhapaa',
                'short_description' => 'Building opportunities for youth and communities in Nepal.',
                'description' => 'Baakhapaa brings together education, technology, and local opportunity to support community-led progress.',
                'color' => '#D4AF37',
                'bg_color' => '#fff6e0',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'name' => 'Skill Sikka',
                'slug' => 'skill-sikka',
                'short_description' => 'Practical learning for skills that can be put to use.',
                'description' => 'Skill Sikka focuses on making learning practical, accessible, and connected to real opportunities.',
                'color' => '#D4AF37',
                'bg_color' => '#fff6e0',
                'is_active' => true,
                'order' => 2,
            ],
            [
                'name' => 'HillyChilly',
                'slug' => 'hillychilly',
                'short_description' => 'A project supporting tourism and local economies.',
                'description' => 'HillyChilly is part of an effort to connect local places and experiences with new opportunities.',
                'color' => '#D4AF37',
                'bg_color' => '#fff6e0',
                'is_active' => true,
                'order' => 3,
            ],
            [
                'name' => 'Future Builders',
                'slug' => 'future-builders',
                'short_description' => 'Encouraging young people to learn, build, and lead.',
                'description' => 'Future Builders supports young people as they develop skills, confidence, and ideas for their communities.',
                'color' => '#D4AF37',
                'bg_color' => '#fff6e0',
                'is_active' => true,
                'order' => 4,
            ],
        ];

        foreach ($projects as $project) {
            Project::firstOrCreate(
                ['slug' => $project['slug']],
                $project,
            );
        }
    }
}
