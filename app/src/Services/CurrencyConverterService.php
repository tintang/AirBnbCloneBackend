<?php


namespace App\Services;


use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Cache\CacheItem;

class CurrencyConverterService
{

    public const CURRENCY_RATES_CACHE_KEY = 'currency_rates';

    /**
     * @var CurrencyRateApiService
     */
    private CurrencyRateApiService $apiService;

    /**
     * @var AdapterInterface
     */
    private AdapterInterface $adapter;

    /**
     * CurrencyConverterService constructor.
     * @param CurrencyRateApiService $apiService
     * @param AdapterInterface $adapter
     */
    public function __construct(CurrencyRateApiService $apiService, AdapterInterface $adapter)
    {
        $this->apiService = $apiService;
        $this->adapter = $adapter;
    }

    private function getCurrencyRates(string $base)
    {
        $cacheItem = $this->adapter->getItem(static::CURRENCY_RATES_CACHE_KEY);

        if (!$cacheItem->isHit()) {
            $currencyRates = $this->apiService->getCurrentExchangeRates($base);
            $cacheItem->set($currencyRates);
            $cacheItem->expiresAfter(new \DateInterval('1D'));
            $this->adapter->save($cacheItem);
        }

        return $cacheItem->get();
    }

    public function convertCurrency(float $amount, string $base, string $dest): float
    {
        $currencyRates = $this->getCurrencyRates($base);

        if (!($this->checkIfCurrencyExists($base, $currencyRates) && $this->checkIfCurrencyExists($dest, $currencyRates))) {
            throw new \InvalidArgumentException('currency doesn\'t exist!');
        }

        if ($base === $dest) {
            throw new \InvalidArgumentException('currencies should not be the same');
        }

        if ($currencyRates['base'] !== $base) {
            $newCurrency = $currencyRates['rates'][$base];
            $convertFactor = 1 / $newCurrency;
            return round($amount * $currencyRates['rates'][$dest] * $convertFactor, 2);
        }

        return round($amount * $currencyRates['rates'][$dest], 2);
    }

    public function checkIfCurrencyExists(string $currency, array $currencyRates)
    {
        return $currencyRates['base'] === $currency || in_array($currency, array_keys($currencyRates['rates']), true);
    }

}