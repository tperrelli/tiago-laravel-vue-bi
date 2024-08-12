<?php

namespace App\Repositories\Criterias;

use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Interfaces\CriteriaInterface;

class NameCriteria implements CriteriaInterface
{
    public function apply(Builder $query, array $filters): Builder
    {
        if (!empty($filters['name'])) {
            $query->where('name', 'like', '%'.$filters['name'].'%');
        }

        return $query;
    }
}