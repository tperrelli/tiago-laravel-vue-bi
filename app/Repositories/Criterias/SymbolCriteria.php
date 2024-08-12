<?php

namespace App\Repositories\Criterias;

use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Interfaces\CriteriaInterface;

class SymbolCriteria implements CriteriaInterface
{
    public function apply(Builder $query, array $filters): Builder
    {
        if (!empty($filters['symbol'])) {
            $query->where('small_name', $filters['symbol']);
        }

        return $query;
    }
}