<?php

use Illuminate\Database\Seeder;
use App\Models\t_inv_order;
use App\Models\t_inv_order_detail;
use Carbon\Carbon;
use App\Models\m_inv_item;
use App\Models\User;

class t_inv_order_seeder extends Seeder
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
                'order_number' => '170420220001',
                'order_date'   => Carbon::now(),
                'order_by'     => User::where('name','=','ADMIN')->first()->uid,
                'is_received'  => false,
                'order_detail' => [
                    [
                        'item'      => 'Sirup Marjan',
                        'qty'       => 3,
                    ],
                    [
                        'item'      => 'Sapu Lidi',
                        'qty'       => 2,
                    ]
                ]
            ],
            [
                'order_number' => '170420220002',
                'order_date'   => Carbon::now()->addHours(1),
                'order_by'     => User::where('name','=','ADMIN')->first()->uid,
                'is_received'  => false,
                'order_detail' => [
                    [
                        'item'      => 'Kipas Angin',
                        'qty'       => 1,
                    ],
                    [
                        'item'      => 'Chitato',
                        'qty'       => 5,
                    ],
                    [
                        'item'      => 'Sendal Jepit',
                        'qty'       => 2,
                    ]
                ]
            ]
        ];

        foreach ($data_basic as $key => $value) {
            $saveOrder =  t_inv_order::create([
                'order_number'  => $value['order_number'],
                'order_date'    => $value['order_date'],
                'order_by'      => $value['order_by'],
                'is_received'   => $value['is_received'],
            ]);
            $uidSaveorder = $saveOrder->uid;
            foreach ($value['order_detail'] as $keyx => $valuex) {
                $saveOrderDetail = t_inv_order_detail::create([
                    'uid_order'     => $uidSaveorder,
                    'uid_item'      => m_inv_item::where('item_name','=', $valuex['item'])->first()->uid,
                    'qty'           => $valuex['qty'],
                ]);
            }
        }
        
    }
}
