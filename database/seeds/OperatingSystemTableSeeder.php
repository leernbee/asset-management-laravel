<?php

use App\OperatingSystem;
use Illuminate\Database\Seeder;

class OperatingSystemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $operating_systems = [
            'MS-Windows',
            'Ubuntu',
            'Mac OS'
        ];

        foreach ($operating_systems as $operating_system) {
            OperatingSystem::create(['name' => $operating_system]);
        }
    }
}
