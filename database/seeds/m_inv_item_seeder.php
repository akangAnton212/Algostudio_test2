<?php

use Illuminate\Database\Seeder;
use App\Models\m_inv_item;
use App\Models\m_inv_item_group;
use App\Models\m_inv_item_type;

class m_inv_item_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arrItem = ['Sendal Jepit|Lain-lain|Type 1', 'Sapu Lidi|Lain-lain|Type 2', 'Chitato|Makanan|Type 1','Sirup Marjan|Minuman|Type 2','Kipas Angin|Lain-lain|Type 2'];
        for ($i=0; $i < count($arrItem) ; $i++) { 
            $splitStr = explode('|', $arrItem[$i]);
            $item = new m_inv_item;
            $item->item_name = $splitStr[0];
            $item->uid_item_group = m_inv_item_group::where('group_name','=',$splitStr[1])->first()->uid;
            $item->uid_item_type = m_inv_item_type::where('type_name','=',$splitStr[2])->first()->uid;
            $item->uid_store    = null;
            $item->last_price = 0;
            $item->stock = 0;
            $item->item_description = null;
            $item->save();
        }
    }
}
