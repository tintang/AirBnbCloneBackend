<?php

namespace App\Adapter;

use App\Entity\User;

interface SetCurrentUserInterface
{
    public function setCurrentUser(User $user);
    public function getUser();
}