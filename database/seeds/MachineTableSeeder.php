<?php

use Illuminate\Database\Seeder;
use App\Machine;

class MachineTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for ($x = 1; $x <= 50; $x++) {
            $tag = "LM" . str_pad($x, 4, '0', STR_PAD_LEFT);

            Machine::create([
                'machine_tag' => $tag,
                'name' => 'Lenovo ThinkPad E580',
                'machine_type_id' => 2,
                'operating_system_id' => 1,
                'manufacturer' => 'Lenovo',
                'model' => 'E580',
                'serial' => $faker->ean13,
                'support_link' => 'https://support.lenovo.com/ph/en/',
                'service_date' => '01-01-2022',
                'status_id' => 1,
                'location_id' => 5,
                'notes' => 'n/a'
            ]);
        }

        for ($x = 1; $x <= 50; $x++) {
            $tag = "DM" . str_pad($x, 4, '0', STR_PAD_LEFT);

            Machine::create([
                'machine_tag' => $tag,
                'name' => 'Lenovo ThinkCentre M710e SFF',
                'machine_type_id' => 1,
                'operating_system_id' => 1,
                'manufacturer' => 'Lenovo',
                'model' => 'M710e',
                'serial' => $faker->ean13,
                'support_link' => 'https://support.lenovo.com/ph/en/',
                'service_date' => '01-01-2022',
                'status_id' => 1,
                'location_id' => 5,
                'notes' => 'n/a'
            ]);
        }

        for ($x = 1; $x <= 50; $x++) {
            $tag = "LQ" . str_pad($x, 4, '0', STR_PAD_LEFT);

            Machine::create([
                'machine_tag' => $tag,
                'name' => 'Lenovo ThinkPad E580',
                'machine_type_id' => 2,
                'operating_system_id' => 1,
                'manufacturer' => 'Lenovo',
                'model' => 'E580',
                'serial' => $faker->ean13,
                'support_link' => 'https://support.lenovo.com/ph/en/',
                'service_date' => '01-01-2022',
                'status_id' => 1,
                'location_id' => 8,
                'notes' => 'n/a'
            ]);
        }

        for ($x = 1; $x <= 50; $x++) {
            $tag = "DQ" . str_pad($x, 4, '0', STR_PAD_LEFT);

            Machine::create([
                'machine_tag' => $tag,
                'name' => 'Lenovo ThinkCentre M710e SFF',
                'machine_type_id' => 1,
                'operating_system_id' => 1,
                'manufacturer' => 'Lenovo',
                'model' => 'M710e',
                'serial' => $faker->ean13,
                'support_link' => 'https://support.lenovo.com/ph/en/',
                'service_date' => '01-01-2022',
                'status_id' => 1,
                'location_id' => 8,
                'notes' => 'n/a'
            ]);
        }
    }
}
