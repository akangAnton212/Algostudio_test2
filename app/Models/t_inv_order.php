<?php

namespace App\Models;
use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Model;


class t_inv_order extends Model
{
    protected $table = 't_inv_order';

    protected $fillable = [
        'order_number',
        'order_date',
        'order_by',
        'is_received',
        'enabled'
    ];

    public $incrementing = true;
    protected $primaryKey = 'id';
    public $timestamps = true;

    public function orderDetail()
    {
        return $this->hasMany(t_inv_order_detail::class, 'uid_order', 'uid');
    }

    public function userOrder()
    {
        return $this->hasOne(User::class, 'uid', 'order_by');
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
