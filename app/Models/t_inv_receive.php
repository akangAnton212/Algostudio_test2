<?php

namespace App\Models;
use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Model;

class t_inv_receive extends Model
{
    protected $table = 't_inv_receive';

    protected $fillable = [
        'uid_order',
        'receive_date',
        'receive_num',
        'invoice_num',
        'delivery_note',
        'uid_receive_by',
        'enabled'
    ];

    public $incrementing = true;
    protected $primaryKey = 'id';
    public $timestamps = true;

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
