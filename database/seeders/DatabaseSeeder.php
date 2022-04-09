<?php

namespace Database\Seeders;

use App\Models\Artist;
use App\Models\Album;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AlbumSeeder::class,
            DairySeeder::class
        ]);

        // \App\Models\User::factory(10)->create();
    }
}
