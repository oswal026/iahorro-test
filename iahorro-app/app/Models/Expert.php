<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expert extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id', 'first_name', 'last_name', 'email', 'phone'
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public function customers()
    {
        return $this->belongsToMany(Customer::class, 'customers_experts', 'experts_id', 'customers_id')
            ->as('request')
            ->withPivot('id', 'amount', 'status')
            ->withTimestamps();
    }

}
