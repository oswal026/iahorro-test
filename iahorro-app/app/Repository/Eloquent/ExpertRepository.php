<?php
namespace App\Repository\Eloquent;

use App\Models\Expert;
use App\Repository\ExpertRepositoryInterface;
use Illuminate\Support\Collection;

class ExpertRepository extends BaseRepository implements ExpertRepositoryInterface
{

    /**
     * ExpertRepository constructor.
     *
     * @param Expert $model
     */
    public function __construct(Expert $model)
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