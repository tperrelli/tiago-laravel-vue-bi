<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\StockDetailResource;
use App\Repositories\StockRepository;
use App\Http\Resources\StockResource;
use App\Repositories\Criterias\NameCriteria;
use App\Repositories\Criterias\AmountCriteria;
use App\Repositories\Criterias\SymbolCriteria;
use App\Repositories\Criterias\MonthCriteria;
use Illuminate\Http\Resources\Json\JsonResource;

class StockController extends Controller
{
    /** 
     * Class constructor
     * @param StockRepository */
    public function __construct(protected StockRepository $repository)
    {}

    /**
     * Display a listing of the resource.
     * 
     * @param Request $request
     */
    public function index(Request $request): JsonResource
    {
        $criterias = [
            new NameCriteria,
            new AmountCriteria,
            new SymbolCriteria,
            new MonthCriteria,
        ];

        $result = $this->repository->filter($request->all(), $criterias);

        $data = [];
        foreach ($result as $item) {
            if (!isset($data[$item->small_name])) {
                $data[$item->small_name] = [
                    'name' => $item->name,
                    'small_name' => $item->small_name,
                    'total' => array_fill(0, 6, 0)
                ];
            }
            $data[$item->small_name]['total'][$item->month - 1] = $item->total;
        }
        
        return StockResource::collection($data);
    }

    /**
     * Display the specified resource.
     * 
     * @param string $string
     */
    public function show(string $symbol): JsonResource
    {
        $data = $this->repository->findBySymbol($symbol);
        
        return StockDetailResource::collection($data);
    }
}
