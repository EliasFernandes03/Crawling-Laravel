<?php

namespace App\Repository;

use App\Models\Currency;

class CurrencyRepository
{
    public function saveCurrency(array $data)
    {
        return Currency::create($data);
    }

    public function getAllCurrencies()
    {
        return Currency::all();
    }

    public function getCurrencyByCodeAndDate($code, $date)
    {
        return Currency::where('code', $code)
                       ->whereDate('created_at', $date)
                       ->get();
    }
}
