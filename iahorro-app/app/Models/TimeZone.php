<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TimeZone extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id', 'from', 'to'
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
}
