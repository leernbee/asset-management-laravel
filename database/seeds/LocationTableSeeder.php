<?php

use App\Location;
use Illuminate\Database\Seeder;

class LocationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $locations = [
            [
                'name' => 'Zuitt Quezon City Branch',
                'address1' => '3rd Floor Caswynn Building, No. 134 Timog Avenue, Sacred Heart',
                'city' => 'Quezon City',
                'state' => 'NCR',
                'country' => 'Philippines',
                'zip' => '1103',
                'manager_id' => 1
            ],
            [
                'name' => 'Zuitt Makati City Branch',
                'address1' => '3rd Floor, 399 Sen. Gil J. Puyat Ave',
                'city' => 'Makati City',
                'state' => 'NCR',
                'country' => 'Philippines',
                'zip' => '1200',
                'manager_id' => 1
            ],
            [
                'name' => 'Makati BootCamp Room 1',
                'parent_id' => 2
            ],
            [
                'name' => 'Makati BootCamp Room 2',
                'parent_id' => 2
            ],
            [
                'name' => 'Makati Stock Room',
                'parent_id' => 2
            ],
            [
                'name' => 'QC BootCamp Room 1',
                'parent_id' => 1
            ],
            [
                'name' => 'QC BootCamp Room 2',
                'parent_id' => 1
            ],
            [
                'name' => 'QC Stock Room',
                'parent_id' => 1
            ]
        ];

        foreach ($locations as $location) {
            Location::create($location);
        }
    }
}
