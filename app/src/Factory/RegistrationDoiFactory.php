<?php


namespace App\Factory;


use App\Entity\RegistrationDOI;
use App\Entity\User;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class RegistrationDoiFactory
{

    /**
     * @var TokenGeneratorInterface
     */
    private TokenGeneratorInterface $generator;

    /**
     * RegistrationDoiFactory constructor.
     * @param TokenGeneratorInterface $generator
     */
    public function __construct(TokenGeneratorInterface $generator)
    {
        $this->generator = $generator;
    }

    public function create(User $user): RegistrationDOI
    {
        $registrationDOI = new RegistrationDOI($user);
        $registrationDOI->setToken($this->generator->generateToken());
        return $registrationDOI;
    }

}