<?php


namespace App\Services;


use App\Entity\RegistrationDOI;
use App\Entity\User;
use App\Factory\RegistrationDoiFactory;
use App\Services\Exceptions\AlreadyVerifiedException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class RegistrationDOIMailingService
{

    /**
     * @var MailerInterface
     */
    private MailerInterface $mailer;

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;
    /**
     * @var RegistrationDoiFactory
     */
    private RegistrationDoiFactory $factory;

    /**
     * RegistrationDOIService constructor.
     * @param MailerInterface $mailer
     * @param EntityManagerInterface $entityManager
     * @param RegistrationDoiFactory $factory
     */
    public function __construct(MailerInterface $mailer, EntityManagerInterface $entityManager, RegistrationDoiFactory $factory)
    {
        $this->mailer = $mailer;
        $this->entityManager = $entityManager;
        $this->factory = $factory;
    }

    /**
     * @param User $user
     * @throws AlreadyVerifiedException
     */
    public function sendMail(User $user)
    {
        if ($user->isVerified()) {
            throw new AlreadyVerifiedException();
        }

        $doi = $this->factory->create($user);
        try {
            $email = (new Email())
                ->from('hello@example.com')
                ->to('you@example.com')
                ->subject('Time for Symfony Mailer!')
                ->text('Sending emails is fun again!')
                ->html('<p>See Twig integration for better HTML integration!</p>');

            $this->mailer->send($email);
            $doi->setStatus(RegistrationDOI::STATUS_SEND);
            $doi->setDoiSent(new \DateTimeImmutable());
        } catch (TransportExceptionInterface $exception) {
            $doi->setStatus(RegistrationDOI::STATUS_MAIL_ERROR);
        }

        $this->entityManager->persist($doi);
        $this->entityManager->flush();
    }

}