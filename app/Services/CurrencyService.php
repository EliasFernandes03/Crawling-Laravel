<?php

namespace App\Services;

use App\Repository\CurrencyRepository;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class CurrencyService
{
    protected $currencyRepository;

    public function __construct(CurrencyRepository $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }
    
    public function fetchCurrencyData($code)
    {
        $url = "https://pt.wikipedia.org/wiki/ISO_4217";

        $client = new Client();
        $response = $client->request('GET', $url);

        $html = $response->getBody()->getContents();
        $crawler = new Crawler($html);

        $currencyFound = null;
        $crawler->filter('.wikitable tbody tr')->each(function ($row) use ($code, &$currencyFound) {
            $cells = $row->filter('td');
            if ($cells->count() >= 4 && $cells->eq(0)->text() === $code) {
                $currencyFound = [
                    'code' => $cells->eq(0)->text(),
                    'decimals' => $cells->eq(1)->text(),
                    'numeric' => $cells->eq(2)->text(),
                    'name' => $cells->eq(3)->text(),
                ];

                $this->currencyRepository->saveCurrency($currencyFound);

                return false;
            }
        });

        return $currencyFound;
    }

    public function fetchAllCurrencies()
    {
        return $this->currencyRepository->getAllCurrencies();
    }

    public function fetchCurrencyByCodeAndDate($code, $date)
    {
        return $this->currencyRepository->getCurrencyByCodeAndDate($code, $date);
    }
}
