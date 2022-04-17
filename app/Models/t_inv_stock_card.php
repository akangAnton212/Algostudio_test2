<?php

namespace App\Models;
use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Model;

class t_inv_stock_card extends Model
{
    protected $table = 't_inv_stock_card';

    protected $fillable = [
        'trans_type',
        'trans_date',
        'uid_item',
        'initial_balance',
        'qty',
        'final_balance',
        'information',
        'ref_number',
        'enabled'
    ];

    public $incrementing = true;
    protected $primaryKey = 'id';
    public $timestamps = true;

    public function item()
    {
        return $this->hasOne(m_inv_item::class, 'uid', 'uid_item');
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    public static function boot() {
        parent::boot();

        // Listen creating event
        self::creating(function ($model) {
            $model->uid = (string) Str::uuid();
        });
    }
}
