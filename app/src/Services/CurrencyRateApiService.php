<?php


namespace App\Services;


use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\Serializer\Encoder\JsonDecode;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CurrencyRateApiService
{

    /**
     * @var HttpClientInterface
     */
    private HttpClientInterface $client;

    /**
     * CurrencyConverterApiService constructor.
     * @param HttpClientInterface $client
     * @param DecoderInterface $decoder
     */
    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /** @noinspection PhpComposerExtensionStubsInspection */
    public function getCurrentExchangeRates(string $base = 'EUR')
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        return json_decode($this->client->request(
            'GET',
            'https://api.exchangeratesapi.io/latest', [
            'query' => [
                'base' => $base
            ]
        ])->getContent());
    }

}