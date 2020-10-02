<?php

namespace App\EventSubscriber;

use App\Event\RegistrationEvent;
use App\Services\Exceptions\AlreadyVerifiedException;
use App\Services\RegistrationDOIMailingService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EmailNotificationEventSubscriber implements EventSubscriberInterface
{

    private RegistrationDOIMailingService $registrationDOIMailingService;

    public function __construct(RegistrationDOIMailingService $registrationDOIMailingService)
    {
        $this->registrationDOIMailingService = $registrationDOIMailingService;
    }

    public static function getSubscribedEvents()
    {
        return [
            RegistrationEvent::class => 'sendDOI'
        ];
    }

    /**
     * @param RegistrationEvent $event
     * @throws AlreadyVerifiedException
     */
    public function sendDOI(RegistrationEvent $event)
    {
        $this->registrationDOIMailingService->sendMail($event->getUser());
    }

}