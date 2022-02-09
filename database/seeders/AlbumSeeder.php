<?php

namespace Database\Seeders;

use App\Models\Artist;
use Illuminate\Database\Seeder;
use App\Models\Album;
class AlbumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $albums = Album::factory(30)->create();

        Artist::factory(8)->create()->each(function($artist) use ($albums){
            $artist->albums()->attach($albums->random(2));
        });
       // Album::factory()->count(20)->create();
    }
}
