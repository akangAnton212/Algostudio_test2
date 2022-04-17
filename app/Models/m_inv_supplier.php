<?php

namespace App\Models;
use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Model;

class m_inv_supplier extends Model
{
    protected $table = 'm_inv_supplier';

    protected $fillable = [
        'supplier_name',
        'address',
        'npwp_num',
        'phone',
        'email',
        'pic',
        'pic_phone',
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
