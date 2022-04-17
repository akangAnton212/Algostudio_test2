<?php

use Illuminate\Database\Seeder;
use App\Models\m_inv_supplier;

class m_inv_supplier_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public $data_basic = [
        [
            'supplier_name' => 'PT UNILEVER INDONESIA',
            'address'       => 'BEKASI',
            'npwp_num'      => '1234',
            'phone'         => '021-232434',
            'email'         => 'uni@mail.com',
            'pic'           => 'Junaedi',
            'pic_phone'     => '089454534343',
        ],
        [
            'supplier_name' => 'PT Indomarco Adiprima',
            'address'       => 'BEKASI',
            'npwp_num'      => '12345',
            'phone'         => '021-232342',
            'email'         => 'indo@mail.com',
            'pic'           => 'Neni',
            'pic_phone'     => '08563243244',
        ],
    ];

    public function run()
    {
        foreach ($this->data_basic as $key => $value) {
            $rtx = m_inv_supplier::create($value);
        }
    }
}
