<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id', 'first_name', 'last_name', 'email', 'phone', 'net_income', 'time_zones_id'
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public function timeZone()
    {
        return $this->belongsTo(Customer::class);
    }

    public function experts()
    {
        return $this->belongsToMany(Expert::class, 'customers_experts', 'customers_id', 'experts_id')
            ->as('request')
            ->withPivot('id', 'amount', 'status')
            ->withTimestamps();
    }
}
