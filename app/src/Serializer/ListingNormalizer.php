<?php

namespace App\Serializer;

use App\Entity\Listing;
use App\Services\CurrencyConverterService;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;

class ListingNormalizer implements ContextAwareNormalizerInterface, NormalizerAwareInterface
{

    use NormalizerAwareTrait;

    private const ALREADY_CALLED = 'LISTING_ATTRIBUTE_NORMALIZER_ALREADY_CALLED';

    private RequestStack $requestStack;

    private CurrencyConverterService $currencyConverterService;

    public function __construct(RequestStack $requestStack, CurrencyConverterService $currencyConverterService)
    {
        $this->requestStack = $requestStack;
        $this->currencyConverterService = $currencyConverterService;
    }

    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        if (isset($context[self::ALREADY_CALLED])) {
            return false;
        }

        return $data instanceof Listing;
    }

    /**
     * @param Listing $object
     * @param string|null $format
     * @param array $context
     * @return array|\ArrayObject|bool|float|int|string|null
     * @throws ExceptionInterface
     */
    public function normalize($object, string $format = null, array $context = [])
    {
        $context[self::ALREADY_CALLED] = true;

        $currentRequest = $this->requestStack->getCurrentRequest();
        $data = $this->normalizer->normalize($object, $format, $context);


        if ($data['price'] !== null && $destCurrency = $currentRequest->headers->get('X-CURRENCY')) {
            $data['price'] =
                (string)$this->currencyConverterService->convertCurrency(
                    (float)$object->getPrice(),
                    $object->getCurrency(),
                    $destCurrency
                );
            $data['currency'] = $destCurrency;
        }
        $data['ratingScore'] = $object->getRatingScore();

        return $data;
    }

}