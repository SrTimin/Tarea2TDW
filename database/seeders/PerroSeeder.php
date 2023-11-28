<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Perro;

class PerroSeeder extends Seeder
{
    public function run()
    {
        Perro::factory()->count(10)->create();
    }
}
