<?php

namespace App\Entity;

use App\Repository\RegistrationDOIRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RegistrationDOIRepository::class)
 */
class RegistrationDOI
{

    const STATUS_SEND = 'send';

    const STATUS_MAIL_ERROR = 'mail_error';

    const STATUS_CREATED = 'created';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $doiSent;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $doiSuccess;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $status;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $doiCreated;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $token;

    /**
     * RegistrationDOI constructor.
     */
    public function __construct(User $user)
    {
        $this->doiCreated = new \DateTimeImmutable();
        $this->status = self::STATUS_CREATED;
        $this->user = $user;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getDoiSent(): ?\DateTimeImmutable
    {
        return $this->doiSent;
    }

    public function setDoiSent(?\DateTimeImmutable $doiSent): self
    {
        $this->doiSent = $doiSent;

        return $this;
    }

    public function getDoiSuccess(): ?\DateTimeImmutable
    {
        return $this->doiSuccess;
    }

    public function setDoiSuccess(?\DateTimeImmutable $doiSuccess): self
    {
        $this->doiSuccess = $doiSuccess;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getDoiCreated(): ?\DateTimeImmutable
    {
        return $this->doiCreated;
    }

    public function setDoiCreated(\DateTimeImmutable $doiCreated): self
    {
        $this->doiCreated = $doiCreated;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }
}
