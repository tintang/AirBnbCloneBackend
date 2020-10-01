<?php


namespace App\Tests\Provider;


use App\Provider\CountryInformationProvider;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class CountryInformationProviderTest extends TestCase
{

    public function testGetCurrentCountryWithExistingCountryCode()
    {
        list($requestStack, $request, $mapping) = $this->getMocks();

        $request->headers->set('X-COUNTRY', 'DEU');
        $requestStack->method('getCurrentRequest')->willReturn($request);

        $countryInformationProvider = new CountryInformationProvider($requestStack, $mapping);
        $this->assertEquals('DEU', $countryInformationProvider->getCurrentCountry());
    }

    public function testGetCurrentCountryWithNonExistingCountryCode()
    {
        list($requestStack, $request, $mapping) = $this->getMocks();
        $requestStack->method('getCurrentRequest')->willReturn($request);

        $this->expectException(\Exception::class);
        $countryInformationProvider = new CountryInformationProvider($requestStack, $mapping);
        $countryInformationProvider->getCurrentCountry();
    }

    public function testGetCurrencyFromRequestWithExistingCountry()
    {
        list($requestStack, $request, $mapping) = $this->getMocks();
        $request->headers->set('X-COUNTRY', 'DEU');
        $requestStack->method('getCurrentRequest')->willReturn($request);

        $provider = new CountryInformationProvider($requestStack, $mapping);
        $this->assertEquals('EUR', $provider->getUserCurrency());
    }

    public function testGetCurrencyFromRequestWithNonExistingCountry()
    {
        list($requestStack, $request, $mapping) = $this->getMocks();
        $requestStack->method('getCurrentRequest')->willReturn($request);

        $provider = new CountryInformationProvider($requestStack, $mapping);
        $this->assertEquals('USD', $provider->getUserCurrency());
    }

    /**
     * @return array
     */
    public function getMocks(): array
    {
        /** @var MockObject&RequestStack $requestStack */
        /** @var MockObject&Request $request */
        $requestStack = $this->createMock(RequestStack::class);
        $request = $this->createMock(Request::class);
        $mapping = [
            'currency' => [
                'USA' => 'USD',
                'DEU' => 'EUR'
            ]
        ];
        $request->headers = new ParameterBag();
        return array($requestStack, $request, $mapping);
    }

}