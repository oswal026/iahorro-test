<?php
namespace App\Repository\Eloquent;

use App\Models\TimeZone;
use App\Repository\TimeZoneRepositoryInterface;
use Illuminate\Support\Collection;

class TimeZoneRepository extends BaseRepository implements TimeZoneRepositoryInterface
{

    /**
     * ExpertRepository constructor.
     *
     * @param TimeZone $model
     */
    public function __construct(TimeZone $model)
    {
        parent::__construct($model);
    }

    /**
     * @return Collection
     */
    public function all()
    {
        return $this->model->all();
    }
}