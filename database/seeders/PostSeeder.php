<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $users = [
            'ali@example.com',
            'sara@example.com',
            'mohamed@example.com',
            'nada@example.com',
            'youssef@example.com',
        ];

        foreach ($users as $email) {
            $user = User::where('email', $email)->first();
            Post::create([
                'user_id' => $user->id,
                'title' => "Post 1 by $user->name",
                'body' => "Body of post 1 by $user->name",
                'image' => null,
            ]);

            Post::create([
                'user_id' => $user->id,
                'title' => "Post 2 by $user->name",
                'body' => "Body of post 2 by $user->name",
                'image' => null,
            ]);

            Post::create([
                'user_id' => $user->id,
                'title' => "Post 3 by $user->name",
                'body' => "Body of post 3 by $user->name",
                'image' => null,
            ]);

            Post::create([
                'user_id' => $user->id,
                'title' => "Post 4 by $user->name",
                'body' => "Body of post 4 by $user->name",
                'image' => null,
            ]);

            Post::create([
                'user_id' => $user->id,
                'title' => "Post 5 by $user->name",
                'body' => "Body of post 5 by $user->name",
                'image' => null,
            ]);
        }
    }
}
