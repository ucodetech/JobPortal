<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tag;
use App\Models\Listing;
use App\Models\User;
use App\Models\Click;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //first create user, the create user returns a collections of eloquent model of the user object
        //we then use each() method step over each one of them to have access of each user object
        //then we pass in the listing method and generate listings and associate it with user
        //we do same for tags
        $tags = Tag::factory(10)->create();
        User::factory(20)->create()->each(function($user) use ($tags) {
            Listing::factory(rand(1, 4))->create([
                    'user_id' => $user
            ])->each(function($listing) use ($tags) {
                $listing->tags()->attach($tags->random(2));
            });
        });
        // Tag::factory(10)->create();
        // Listing::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
