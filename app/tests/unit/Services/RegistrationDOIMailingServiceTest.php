<?php


use App\Entity\RegistrationDOI as RegistrationDOI;
use App\Entity\User;
use App\Factory\RegistrationDoiFactory;
use App\Services\Exceptions\AlreadyVerifiedException;
use App\Services\RegistrationDOIMailingService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\Mailer\MailerInterface;

class RegistrationDOIMailingServiceTest extends TestCase
{

    public function testSuccessful()
    {
        /** @var User&MockObject $user */
        /** @var EntityManagerInterface&MockObject $entityManager */
        /** @var RegistrationDoiFactory&MockObject $doiFactory */
        list($mailer, $user, $entityManager, $doiFactory, $doi) = $this->prepareMocks();

        $doiFactory->method('create')->willReturn($doi);
        $user->method('isVerified')->willReturn(false);


        $mailer->expects($this->once())->method('send');
        $entityManager->expects($this->atLeastOnce())->method('persist')->with($doi);
        $entityManager->expects($this->atLeastOnce())->method('flush');
        $doi->expects($this->atLeastOnce())->method('setStatus')->with(RegistrationDOI::STATUS_SEND);

        $registrationService = new RegistrationDOIMailingService($mailer, $entityManager, $doiFactory);
        $registrationService->sendMail($user);
    }

    public function testMailingFailed()
    {
        /** @var MailerInterface&MockObject $mailer */
        /** @var User&MockObject $user */
        /** @var EntityManagerInterface&MockObject $entityManager */
        /** @var RegistrationDoiFactory&MockObject $doiFactory */
        /** @var RegistrationDOI&MockObject $doi */
        list($mailer, $user, $entityManager, $doiFactory, $doi) = $this->prepareMocks();

        $mailer->method('send')->willThrowException(new TransportException());
        $doiFactory->method('create')->willReturn($doi);
        $user->method('isVerified')->willReturn(false);


        $doi->expects($this->atLeastOnce())->method('setStatus')->with(RegistrationDOI::STATUS_MAIL_ERROR);
        $entityManager->expects($this->atLeastOnce())->method('persist')->with($doi);
        $entityManager->expects($this->atLeastOnce())->method('flush');

        $registrationService = new RegistrationDOIMailingService($mailer, $entityManager, $doiFactory);
        $registrationService->sendMail($user);
    }

    public function testUserAlreadyVerified()
    {
        /** @var MailerInterface&MockObject $mailer */
        /** @var User&MockObject $user */
        /** @var EntityManagerInterface&MockObject $entityManager */
        /** @var RegistrationDoiFactory&MockObject $doiFactory */
        /** @var RegistrationDOI&MockObject $doi */
        list($mailer, $user, $entityManager, $doiFactory, $doi) = $this->prepareMocks();

        $user->method('isVerified')->willReturn(true);
        $entityManager->expects($this->never())->method('persist');
        $entityManager->expects($this->never())->method('flush');

        $this->expectException(AlreadyVerifiedException::class);

        $registrationService = new RegistrationDOIMailingService($mailer, $entityManager, $doiFactory);
        $registrationService->sendMail($user);
    }

    /**
     * @return array
     */
    public function prepareMocks(): array
    {
        $mailer = $this->createMock(MailerInterface::class);
        /** @var User&MockObject $user */
        $user = $this->createMock(User::class);
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $doiFactory = $this->createMock(RegistrationDoiFactory::class);
        $doi = $this->createMock(RegistrationDOI::class);

        $user->method('getEmail')->willReturn('t-tang@live.de');
        return array($mailer, $user, $entityManager, $doiFactory, $doi);
    }
}