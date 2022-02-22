<?php

use App\SoftwareType;
use Illuminate\Database\Seeder;

class SoftwareTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $software_types = [
            'Productivity',
            'Graphics',
            'Support',
            'Accounting',
            'Development',
            'Others'
        ];

        foreach ($software_types as $software_type) {
            SoftwareType::create(['name' => $software_type]);
        }
    }
}
