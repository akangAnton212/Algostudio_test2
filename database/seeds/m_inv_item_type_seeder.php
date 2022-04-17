<?php

use Illuminate\Database\Seeder;
use App\Models\m_inv_item_type;

class m_inv_item_type_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arrType = ['Type 1', 'Type 2'];
        for ($i=0; $i < count($arrType); $i++) { 
            $itemType = new m_inv_item_type;
            $itemType->type_name = $arrType[$i];
            $itemType->alias_code = null;
            $itemType->alias_name    = null;
            $itemType->description = null;
            $itemType->save();
        }
    }
}
