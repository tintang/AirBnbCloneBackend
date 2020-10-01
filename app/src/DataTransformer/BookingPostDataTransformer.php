<?php


namespace App\DataTransformer;


use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Dto\BookingDto;
use App\Entity\Booking;
use App\Repository\ListingRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Security;

class BookingPostDataTransformer implements DataTransformerInterface
{

    private Security $security;

    private ValidatorInterface $validator;

    private ListingRepository $listingRepository;
    /**
     * @var RequestStack
     */
    private RequestStack $requestStack;

    public function __construct(Security $security, ValidatorInterface $validator, ListingRepository $listingRepository, RequestStack $requestStack)
    {
        $this->security = $security;
        $this->validator = $validator;
        $this->listingRepository = $listingRepository;
        $this->requestStack = $requestStack;
    }

    /**
     * @param BookingDto $object
     * @param string $to
     * @param array $context
     * @return object|void
     */
    public function transform($object, string $to, array $context = [])
    {
        $this->validator->validate($object);
        $listing = $this->listingRepository->find($object->getListing());

        $booking = new Booking();

        /** @noinspection PhpParamsInspection */
        $booking->setBooker($this->security->getUser());
        $booking->setListing($listing);
        $booking->setPrice($listing->getPrice());

        return $booking;
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return $to === Booking::class && (($context['input']['class'] ?? null) !== null);
    }
}