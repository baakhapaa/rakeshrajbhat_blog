<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Blog;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $blogs = [
        ];

        foreach ($blogs as $blog) {
            Blog::create(array_merge($blog, [
                'slug' => Str::slug($blog['title']),
            ]));
        }
    }
}