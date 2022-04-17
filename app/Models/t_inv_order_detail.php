<?php

namespace App\Models;
use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Model;

class t_inv_order_detail extends Model
{
    protected $table = 't_inv_order_detail';

    protected $fillable = [
        'uid_order',
        'uid_item',
        'qty',
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
