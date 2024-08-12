<?php

namespace App\Repositories;

use App\Models\Stocks;
use App\Repositories\BaseRepository;

class StockRepository extends BaseRepository
{
    protected $model = Stocks::class;
}