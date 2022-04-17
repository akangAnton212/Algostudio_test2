<?php

namespace App\Models;
use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Model;

class t_inv_usage_detail extends Model
{
    protected $table = 't_inv_usage_detail';

    protected $fillable = [
        'uid_usage',
        'uid_item',
        'qty',
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
