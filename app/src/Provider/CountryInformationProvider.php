<?php


namespace App\Provider;


use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Intl\Intl;

class CountryInformationProvider
{

    /**
     * @var RequestStack
     */
    private RequestStack $requestStack;
    private array $mapping;

    /**
     * LocaleInformationProvider constructor.
     * @param RequestStack $requestStack
     * @param array $mapping
     */
    public function __construct(RequestStack $requestStack, array $mapping)
    {
        $this->requestStack = $requestStack;
        $this->mapping = $mapping;
    }


    public function getUserCurrency()
    {
        try {
            return $this->mapping['currency'][$this->getCurrentCountry()];
        } catch (\Exception $e) {
            return $this->mapping['currency']['USA'];
        }
    }

    public function getCurrentCountry()
    {
        $request = $this->requestStack->getCurrentRequest();
        $country = $request->headers->get('X-COUNTRY') ?? null;

        if ($country === null) {
            throw new \Exception('No country in header');
        }

        return $country;
    }

}