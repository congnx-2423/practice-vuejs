<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Models\Post;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Factory(Post::class, 10)->create();
    }
}
