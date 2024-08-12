<?php

namespace App\Repositories\Criterias;

use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Interfaces\CriteriaInterface;

class MonthCriteria implements CriteriaInterface
{
    public function apply(Builder $query, array $filters): Builder
    {
        if (!empty($filters['month'])) {
            $query->whereRaw('MONTH(created_at)', $filters['month']);
        }

        return $query;
    }
}