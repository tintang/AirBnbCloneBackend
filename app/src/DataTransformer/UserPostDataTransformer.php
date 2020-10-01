<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Dto\UserDto;
use App\Entity\Address;
use App\Entity\User;
use App\Event\RegistrationEvent;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class UserPostDataTransformer implements DataTransformerInterface
{

    private ValidatorInterface $validator;

    private UserPasswordEncoderInterface $passwordEncoder;

    private EventDispatcherInterface $eventDispatcher;

    public function __construct(ValidatorInterface $validator, UserPasswordEncoderInterface $passwordEncoder, EventDispatcherInterface $eventDispatcher)
    {
        $this->validator = $validator;
        $this->passwordEncoder = $passwordEncoder;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param UserDto $object
     * @param string $to
     * @param array $context
     * @return object|void
     */
    public function transform($object, string $to, array $context = [])
    {

        $this->validator->validate($object);

        $user = new User($object->getEmail());
        $address = new Address();
        $address->setCity($object->getCity());
        $address->setCountry($object->getCountry());
        $address->setExtendedStreet($object->getExtendedStreet());
        $address->setStreet($object->getStreet());
        $address->setZipCode($object->getZipCode());

        $user->setPassword($this->passwordEncoder->encodePassword($user, $object->getPassword()));
        $user->setAddress($address);

        $this->eventDispatcher->dispatch(new RegistrationEvent($user));

        return $user;
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        if ($data instanceof User) {
            return false;
        }

        return $to === User::class && ($context['input']['class'] ?? null) !== null;
    }

}