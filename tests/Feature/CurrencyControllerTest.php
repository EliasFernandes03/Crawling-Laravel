<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\CurrencyController;
use App\Services\CurrencyService;
use Illuminate\Http\Request;
use Mockery;

class CurrencyControllerTest extends TestCase
{
    protected $currencyServiceMock;
    protected $currencyController;

    protected function setUp(): void
    {
        parent::setUp();

        $this->currencyServiceMock = Mockery::mock(CurrencyService::class);
        $this->currencyController = new CurrencyController($this->currencyServiceMock);
    }

    public function testFetchCurrency()
    {
        $codes = 'USD,EUR';
        $currencyData = [
            ['code' => 'USD', 'decimals' => '2', 'numeric' => '840', 'name' => 'United States dollar'],
            ['code' => 'EUR', 'decimals' => '2', 'numeric' => '978', 'name' => 'Euro']
        ];

        $this->currencyServiceMock
            ->shouldReceive('fetchCurrencyData')
            ->with('USD')
            ->andReturn($currencyData[0]);

        $this->currencyServiceMock
            ->shouldReceive('fetchCurrencyData')
            ->with('EUR')
            ->andReturn($currencyData[1]);

        $response = $this->currencyController->fetchCurrency($codes);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals($currencyData, $response->getData(true));
    }

    public function testFetchCurrencyNotFound()
    {
        $codes = 'XYZ';

        $this->currencyServiceMock
            ->shouldReceive('fetchCurrencyData')
            ->with('XYZ')
            ->andReturn(null);

        $response = $this->currencyController->fetchCurrency($codes);

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals(['error' => 'Currencies not found'], $response->getData(true));
    }

    public function testFetchAllCurrencies()
    {
        $currencies = collect([
            ['code' => 'USD', 'decimals' => '2', 'numeric' => '840', 'name' => 'United States dollar'],
            ['code' => 'EUR', 'decimals' => '2', 'numeric' => '978', 'name' => 'Euro']
        ]);

        $this->currencyServiceMock
            ->shouldReceive('fetchAllCurrencies')
            ->andReturn($currencies);

        $response = $this->currencyController->fetchAllCurrencies();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals($currencies->toArray(), $response->getData(true));
    }

    public function testFetchAllCurrenciesNotFound()
    {
        $currencies = collect([]);

        $this->currencyServiceMock
            ->shouldReceive('fetchAllCurrencies')
            ->andReturn($currencies);

        $response = $this->currencyController->fetchAllCurrencies();

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals(['error' => 'No currencies found'], $response->getData(true));
    }

    public function testFetchCurrencyByCodeAndDate()
    {
        $code = 'USD';
        $date = '2024-01-01';
        $currencies = collect([
            ['code' => 'USD', 'decimals' => '2', 'numeric' => '840', 'name' => 'United States dollar']
        ]);

        $request = Request::create('/fetch-currency-by-code-and-date', 'GET', ['code' => $code, 'date' => $date]);

        $this->currencyServiceMock
            ->shouldReceive('fetchCurrencyByCodeAndDate')
            ->with($code, $date)
            ->andReturn($currencies);

        $response = $this->currencyController->fetchCurrencyByCodeAndDate($request);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals($currencies->toArray(), $response->getData(true));
    }

    public function testFetchCurrencyByCodeAndDateNotFound()
    {
        $code = 'XYZ';
        $date = '2024-01-01';
        $currencies = collect([]);

        $request = Request::create('/fetch-currency-by-code-and-date', 'GET', ['code' => $code, 'date' => $date]);

        $this->currencyServiceMock
            ->shouldReceive('fetchCurrencyByCodeAndDate')
            ->with($code, $date)
            ->andReturn($currencies);

        $response = $this->currencyController->fetchCurrencyByCodeAndDate($request);

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals(['error' => 'No currencies found for the specified code and date'], $response->getData(true));
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
