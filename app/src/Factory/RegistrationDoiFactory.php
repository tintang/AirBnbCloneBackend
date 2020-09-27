<?php


namespace App\Factory;


use App\Entity\RegistrationDOI;
use App\Entity\User;

class RegistrationDoiFactory
{
    public function create(User $user): RegistrationDOI
    {
        return new RegistrationDOI($user);
    }

}