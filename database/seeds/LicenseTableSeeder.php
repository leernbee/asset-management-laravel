<?php

use Illuminate\Database\Seeder;
use App\License;

class LicenseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        License::create([
            'name' => 'Microsoft Office',
            'manufacturer' => 'Microsoft',
            'software_type_id' => 1,
            'version' => '2019',
            'vendor' => 'Microsoft',
            'product_key' => $faker->uuid,
            'seats' => '100',
            'license_name' => 'John Doe',
            'license_email' => 'johndoe@email.com',
            'purchase_date' => '11-11-2019',
            'expiration_date' => null,
            'notes' => 'n/a'
        ]);

        License::create([
            'name' => 'Sublime Text 3',
            'manufacturer' => 'Sublime HQ Pty Ltd',
            'software_type_id' => 5,
            'version' => '3211',
            'vendor' => 'Sublime HQ Pty Ltd',
            'product_key' => $faker->uuid,
            'seats' => '100',
            'license_name' => 'John Doe',
            'license_email' => 'johndoe@email.com',
            'purchase_date' => '11-11-2019',
            'expiration_date' => null,
            'notes' => 'n/a'
        ]);
    }
}
