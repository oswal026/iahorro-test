<?php
namespace App\Repository;

use App\Models\TimeZone;
use Illuminate\Support\Collection;

interface TimeZoneRepositoryInterface
{
    public function all();
}