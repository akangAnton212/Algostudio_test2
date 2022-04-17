<?php

namespace App\Models;
use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Model;

class m_inv_item_group extends Model
{
    protected $table = 'm_inv_item_group';

    protected $fillable = [
        'group_name',
        'alias_code',
        'alias_name',
        'description',
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
