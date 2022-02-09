<?php

namespace Database\Seeders;

use App\Models\Dairy;
use Illuminate\Database\Seeder;

class DairySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Dairy::factory(10)->create();
    }
}
