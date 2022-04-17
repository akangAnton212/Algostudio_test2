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
        // $this->call(UserSeeder::class);
        
        $this->call('m_inv_item_group_seeder'); 
        $this->call('m_inv_supplier_seeder');
        $this->call('m_inv_item_type_seeder'); 
        $this->call('m_inv_item_seeder'); 
        $this->call('user_seeder');
        $this->call('t_inv_order_seeder'); 
    }
}
