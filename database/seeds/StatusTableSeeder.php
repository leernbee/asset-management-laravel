<?php

use Illuminate\Database\Seeder;
use App\Status;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            [
                'name' => 'Active',
                'type' => 'Deployable'
            ],
            [
                'name' => 'Retired',
                'type' => 'Undeployable'
            ],
            [
                'name' => 'Ordered',
                'type' => 'Pending'
            ],
            [
                'name' => 'Provisioned',
                'type' => 'Pending'
            ],
            [
                'name' => 'In Repair',
                'type' => 'Pending'
            ],
            [
                'name' => 'Lost',
                'type' => 'Undeployable'
            ]
        ];

        foreach ($statuses as $status) {
            Status::create($status);
        }
    }
}
