<?php

namespace Database\Seeders;

use App\Models\Post;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Database\Seeder;

class gen_slug extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $all_post = Post::all();
        foreach ($all_post as $key => $post) {
            $post->sluggable();
            $post->save();
        }
    }
}
