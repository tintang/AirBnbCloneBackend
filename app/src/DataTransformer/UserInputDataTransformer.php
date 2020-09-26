<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Dto\UserDto;
use App\Entity\Address;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserInputDataTransformer implements DataTransformerInterface
{

    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;
    /**
     * @var UserPasswordEncoderInterface
     */
    private UserPasswordEncoderInterface $passwordEncoder;

    /**
     * UserInputDataTransformer constructor.
     * @param ValidatorInterface $validator
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(ValidatorInterface $validator, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->validator = $validator;
        $this->passwordEncoder = $passwordEncoder;
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