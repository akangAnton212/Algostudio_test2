<?php

namespace App\Models;
use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Model;

class m_inv_item extends Model
{
    protected $table = 'm_inv_item';

    protected $fillable = [
        'item_name',
        'uid_item_group',
        'uid_item_type',
        'uid_store',
        'last_price',
        'stock',
        'item_description',
        'enabled'
    ];

    public $incrementing = true;
    protected $primaryKey = 'id';
    public $timestamps = true;

    public function type()
    {
        return $this->hasOne(m_inv_item_type::class, 'uid', 'uid_item_type');
    }

    public function group()
    {
        return $this->hasOne(m_inv_item_group::class, 'uid', 'uid_item_group');
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
