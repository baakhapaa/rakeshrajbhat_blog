<?php

namespace Database\Seeders;

use App\Models\Research;
use Illuminate\Database\Seeder;

class ResearchSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'title' => 'Building Opportunities Through Education',
                'slug' => 'building-opportunities-through-education',
                'category' => 'Vision',
                'description' => 'A vision for practical, accessible learning that helps young people take part in shaping their communities.',
                'content' => '<p>Education can connect people with the knowledge and confidence to create new opportunities. Making learning practical and accessible is an important part of building a future where young people can contribute and lead.</p>',
                'is_active' => true,
                'is_featured' => true,
                'order' => 1,
            ],
            [
                'title' => 'Digital Skills and Youth Opportunity',
                'slug' => 'digital-skills-and-youth-opportunity',
                'category' => 'Research Papers',
                'description' => 'An ongoing area of inquiry into how practical digital learning can support youth opportunity and local development.',
                'content' => '<p>This research focus considers how hands-on digital skills programs can connect learning with the needs and opportunities of local communities.</p>',
                'is_active' => true,
                'is_featured' => true,
                'order' => 2,
            ],
            [
                'title' => 'AI and ICT for Community Learning',
                'slug' => 'ai-and-ict-for-community-learning',
                'category' => 'Media',
                'description' => 'Stories and resources about using technology to make learning more practical and community-centered.',
                'content' => '<p>This collection follows ideas and activities around AI, ICT, and learning opportunities for young people.</p>',
                'is_active' => true,
                'is_featured' => true,
                'order' => 3,
            ],
        ];

        foreach ($items as $item) {
            Research::firstOrCreate(
                ['slug' => $item['slug']],
                $item,
            );
        }
    }
}
