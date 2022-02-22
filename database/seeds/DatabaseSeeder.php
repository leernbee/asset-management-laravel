<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionTableSeeder::class);
        $this->call(CreateAdminUserSeeder::class);
        $this->call(OperatingSystemTableSeeder::class);
        $this->call(MachineTypeTableSeeder::class);
        $this->call(StatusTableSeeder::class);
        $this->call(SoftwareTypeTableSeeder::class);
        $this->call(LocationTableSeeder::class);
        $this->call(MachineTableSeeder::class);
        $this->call(LicenseTableSeeder::class);
    }
}
