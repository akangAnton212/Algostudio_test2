<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class user_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data_basic = [
            [
                'name'      => 'ADMIN',
                'email'     => 'admin@mail.com',
                'password'  => bcrypt('123123'),
                'role'      => 'ADMIN'
            ],
            [
                'name'      => 'UNILEVER',
                'email'     => 'uni@mail.com',
                'password'  => bcrypt('123123'),
                'role'      => 'SUPPLIER'
            ],
            [
                'name'      => 'DISTRIBUTOR',
                'email'     => 'dist@mail.com',
                'password'  => bcrypt('123123'),
                'role'      => 'DISTRIBUTOR'
            ]
        ];

        foreach ($data_basic as $key => $value) {
            $saveOrder = User::create($value);
        }
       

    }
}
