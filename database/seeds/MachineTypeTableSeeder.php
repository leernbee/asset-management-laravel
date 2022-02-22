<?php

use App\MachineType;
use Illuminate\Database\Seeder;

class MachineTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $machine_types = [
            'Desktop Computers',
            'Laptops',
            'Servers'
        ];

        foreach ($machine_types as $mahine_type) {
            MachineType::create(['name' => $mahine_type]);
        }
    }
}
