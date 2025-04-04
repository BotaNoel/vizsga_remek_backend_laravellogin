<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApartmentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('apartment_types')->insert([
            ['name' => 'Apartman'],
            ['name' => 'Luxus ingatlan'],
            ['name' => 'Szálloda'],
            ['name' => 'Családi ház'],
        ]);
    }
}
