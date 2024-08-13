<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Stocks;
use App\Repositories\StockRepository;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StockControllerTest extends TestCase
{
    use RefreshDatabase; 

    protected $url = '/api/stocks';

    protected $stock;
    protected $stocks;
    protected $totalStocks = 10;
    
    public function setUp(): void
    {
        parent::setUp();

        $this->stocks = Stocks::factory()
            ->count($this->totalStocks)
            ->create();
    }

    public function test_index_dashboard(): void
    {
        $this->mock(StockRepository::class, function ($mock) {
            $mock->shouldReceive('filter')
                ->once()
                ->andReturn($this->stocks);
        });

        $response = $this->get($this->url . '/');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson($response->json());
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'name',
                    'small_name',
                    'total',
                ]
            ]
        ]);
    }

    public function test_index_filtering_data(): void
    {
        $filtered = Stocks::bySmallName('BTC')->get();

        $this->mock(StockRepository::class, function ($mock) use($filtered) {
            $mock->shouldReceive('filter')
                ->once()
                ->andReturn($filtered);
        });
        
        $response = $this->get($this->url . '/?small_name=BTC');
        
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_detail_page(): void
    {
        $symbol = 'BTC';
        $response = $this->get($this->url . '/' . $symbol);
        $response->assertStatus(200);
    }
}