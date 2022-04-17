<?php

use Illuminate\Database\Seeder;
use App\Models\m_inv_item_group;

class m_inv_item_group_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arrGroup = ['Makanan', 'Minuman', 'Lain-lain'];
        for ($i=0; $i < count($arrGroup); $i++) { 
            $itemGroup = new m_inv_item_group;
            $itemGroup->group_name = $arrGroup[$i];
            $itemGroup->alias_code = null;
            $itemGroup->alias_name    = null;
            $itemGroup->description = null;
            $itemGroup->save();
        }
    }
}
