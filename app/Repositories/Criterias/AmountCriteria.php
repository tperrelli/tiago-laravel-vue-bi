<?php

namespace App\Repositories\Criterias;

use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Interfaces\CriteriaInterface;

class AmountCriteria implements CriteriaInterface
{
    public function apply(Builder $query, array $filters): Builder
    {
        if (!empty($filters['amount'])) {
            $query->where('amount', $filters['amount']);
        }

        return $query;
    }
}