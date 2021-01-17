<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerExpert extends Model
{
    protected $table = 'conciertos_grupos';

    protected $fillable = [
        'id', 'amount', 'status', 'customers_id', 'experts_id'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

}
