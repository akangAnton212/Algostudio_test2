<?php

namespace App\Models;
use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Model;

class t_inv_usage extends Model
{
    protected $table = 't_inv_usage';

    protected $fillable = [
        'uid_created_by',
        'created_date',
        'uid_acc_by',
        'acc_date',
        'usage_num',
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
