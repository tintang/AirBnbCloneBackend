<?php

namespace App\EventSubscriber\Doctrine;

use App\Adapter\SetCurrentUserInterface;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Security\Core\Security;

class SetUserSubscriber implements EventSubscriber
{
    /**
     * @var Security
     */
    private Security $security;


    /**
     * SetUserSubscriber constructor.
     * @param Security $security
     */
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        /** @var SetCurrentUserInterface $object */
        $object = $args->getObject();

        if (!($object instanceof SetCurrentUserInterface) || $object->getUser() !== null) {
            return;
        }

        if (!$this->security->getUser()) {
            throw new UnauthorizedHttpException('You are not logged in');
        }

        /** @noinspection PhpParamsInspection */
        $object->setCurrentUser($this->security->getUser());
    }

    public function getSubscribedEvents()
    {
        return [
            Events::prePersist,
        ];
    }
}