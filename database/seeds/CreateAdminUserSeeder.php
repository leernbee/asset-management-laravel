<?php

use Illuminate\Database\Seeder;
use App\User;

use Carbon\Carbon;
use Faker\Factory as Faker;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $user = User::create([
            'first_name' => 'Lliño',
            'last_name' => 'Del Rosario',
            'username' => 'llinodelrosario',
            'email' => 'llino.gadia.delrosario@gmail.com',
            'password' => bcrypt('password'),
            'employee_id' => $faker->numerify('################'),
            'job_title' => 'Administrator',
            'birth_date' => $faker->dateTimeThisCentury->format('m-d-Y'),
            'email_verified_at' => Carbon::now()
        ]);
        $user->assignRole(['Admin']);

        $user = User::create([
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'username' => 'admin',
            'email' => 'admin@iwebtm.com',
            'password' => bcrypt('password'),
            'employee_id' => $faker->numerify('################'),
            'job_title' => 'Administrator',
            'birth_date' => $faker->dateTimeThisCentury->format('m-d-Y'),
            'email_verified_at' => Carbon::now()
        ]);
        $user->assignRole(['Admin']);

        $user = User::create([
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'username' => 'assetmanager',
            'email' => 'assetmanager@iwebtm.com',
            'password' => bcrypt('password'),
            'employee_id' => $faker->numerify('################'),
            'job_title' => 'Asset Manager',
            'birth_date' => $faker->dateTimeThisCentury->format('m-d-Y'),
            'email_verified_at' => Carbon::now()
        ]);
        $user->assignRole(['Asset Manager']);

        $user = User::create([
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'username' => 'itsupport',
            'email' => 'itsupport@iwebtm.com',
            'password' => bcrypt('password'),
            'employee_id' => $faker->numerify('################'),
            'job_title' => 'IT Support',
            'birth_date' => $faker->dateTimeThisCentury->format('m-d-Y'),
            'email_verified_at' => Carbon::now()
        ]);
        $user->assignRole(['IT Support']);

        for ($i = 0; $i < 5; $i++) {
            $username = $faker->userName;
            $user = User::create([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'username' => $username,
                'email' => $username . '@iwebtm.com',
                'password' => bcrypt('password'),
                'employee_id' => $faker->numerify('################'),
                'job_title' => 'IT Support',
                'birth_date' => $faker->dateTimeThisCentury->format('m-d-Y'),
                'email_verified_at' => Carbon::now()
            ]);
            $user->assignRole(['IT Support']);
        }

        $user = User::create([
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'username' => 'user',
            'email' => 'user@iwebtm.com',
            'password' => bcrypt('password'),
            'employee_id' => $faker->numerify('################'),
            'job_title' => 'Software Engineer',
            'birth_date' => $faker->dateTimeThisCentury->format('m-d-Y'),
            'email_verified_at' => Carbon::now()
        ]);
        $user->assignRole(['User']);

        for ($i = 0; $i < 100; $i++) {
            $username = $faker->userName;
            $user = User::create([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'username' => $username,
                'email' => $username . '@iwebtm.com',
                'password' => bcrypt('password'),
                'employee_id' => $faker->numerify('################'),
                'job_title' => $faker->jobTitle,
                'birth_date' => $faker->dateTimeThisCentury->format('m-d-Y'),
                'email_verified_at' => Carbon::now()
            ]);
            $user->assignRole(['User']);
        }
    }
}
