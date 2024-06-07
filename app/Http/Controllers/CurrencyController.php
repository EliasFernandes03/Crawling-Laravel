<?php

namespace App\Http\Controllers;

use App\Services\CurrencyService;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    protected $currencyService;

    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }
    
    public function fetchCurrency($codes)
    {
        $currencyCodes = explode(',', $codes);

        $currencies = [];

        foreach ($currencyCodes as $code) {
            $currency = $this->currencyService->fetchCurrencyData($code);
            if ($currency) {
                $currencies[] = $currency;
            }
        }

        if (!empty($currencies)) {
            return response()->json($currencies);
        } else {
            return response()->json(['error' => 'Currencies not found'], 404);
        }
    }

    public function fetchAllCurrencies()
    {
        $currencies = $this->currencyService->fetchAllCurrencies();
        if ($currencies->isNotEmpty()) {
            return response()->json($currencies);
        } else {
            return response()->json(['error' => 'No currencies found'], 404);
        }
    }

    public function fetchCurrencyByCodeAndDate(Request $request)
    {
        $code = $request->input('code');
        $date = $request->input('date');

        $currencies = $this->currencyService->fetchCurrencyByCodeAndDate($code, $date);

        if ($currencies->isNotEmpty()) {
            return response()->json($currencies);
        } else {
            return response()->json(['error' => 'No currencies found for the specified code and date'], 404);
        }
    }
}

