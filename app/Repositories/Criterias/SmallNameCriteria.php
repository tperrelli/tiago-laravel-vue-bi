<?php

namespace App\Repositories\Criterias;

use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Interfaces\CriteriaInterface;

class SmallNameCriteria implements CriteriaInterface
{
    public function apply(Builder $query, array $filters): Builder
    {
        if (!empty($filters['small_name'])) {
            $query->where('small_name', $filters['small_name']);
        }

        return $query;
    }
}