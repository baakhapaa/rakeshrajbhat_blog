<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Blog;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $blogs = [
            [
                'title' => 'Building Practical Digital Skills for the Future',
                'excerpt' => 'Why accessible, hands-on learning can help young people turn curiosity into confidence.',
                'content' => '<p>Technology is most valuable when people can use it to solve real problems. Practical learning gives young people room to experiment, build, and learn from mistakes instead of only memorizing concepts.</p><p>Creating those opportunities means making learning accessible and connected to everyday life. With the right guidance, a small project can become the starting point for new skills, confidence, and ideas that serve a community.</p>',
                'category' => 'Education',
                'tags' => ['digital skills', 'education', 'youth'],
                'author' => 'Rakesh Rajbhat',
                'is_published' => true,
                'is_featured' => true,
                'published_at' => now()->subDays(20),
            ],
            [
                'title' => 'Technology That Starts With Community Needs',
                'excerpt' => 'A reflection on building useful technology around the people and places it is meant to serve.',
                'content' => '<p>Good technology begins with listening. Before choosing tools or designing a product, it helps to understand the daily challenges people face and what would make a meaningful difference.</p><p>Solutions designed with local context in mind are more likely to be useful and sustainable. That approach can connect skills, education, and entrepreneurship with opportunities close to home.</p>',
                'category' => 'Technology',
                'tags' => ['technology', 'community', 'innovation'],
                'author' => 'Rakesh Rajbhat',
                'is_published' => true,
                'is_featured' => true,
                'published_at' => now()->subDays(10),
            ],
        ];

        foreach ($blogs as $blog) {
            Blog::firstOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($blog['title'])],
                $blog,
            );
        }
    }
}