<?php

namespace App\Repositories;

use App\Repositories\Interfaces\CriteriaInterface;
use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Support\Facades\DB;

abstract class BaseRepository implements BaseRepositoryInterface
{
    /** @var model */
    protected $model;

    /**
     * Find a record by id
     * 
     * @param int id
     */
    public function findByID(int $id)
    {
        return $this->query()
            ->findOrFail($id);
    }
    
    /**
     * Find a record by symbol
     * 
     * @param string symbol
     */
    public function findBySymbol(string $symbol)
    {
        return $this->query()
            ->where('small_name', $symbol)
            ->paginate(30);
    }

    /**
     * Genearte an model query
     */
    protected function query()
    {        
        return app($this->model)::query();
    }

    /**
     * Filters the records according to the given criterias
     *
     * @param array $filters
     * @param array $criteria
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function filter(array $filters, array $criteria = [])
    {
        $query = $this->query();
        
        $query->selectRaw('name, small_name, MONTH(created_at) as month, SUM(amount) as total');

        foreach ($criteria as $criterion) {
            if ($criterion instanceof CriteriaInterface) {
                $query = $criterion->apply($query, $filters);
            }
        }

        $query->whereIn(DB::raw('MONTH(created_at)'), [1,2,3,4,5,6]);
        $query->groupBy('name', 'small_name', DB::raw('MONTH(created_at)'));

        return $query->get();
    }
}