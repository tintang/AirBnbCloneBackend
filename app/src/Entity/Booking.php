<?php

namespace App\Entity;

use App\Adapter\SetCurrentUserInterface;
use App\Repository\BookingRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BookingRepository::class)
 */
class Booking
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $booker;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $bookingDate;

    /**
     * @ORM\ManyToOne(targetEntity=Listing::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $listing;

    /**
     * @ORM\Column(type="boolean")
     */
    private $payed = false;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $price;

    /**
     * Booking constructor.
     */
    public function __construct()
    {
        $this->bookingDate = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBooker(): ?User
    {
        return $this->booker;
    }

    public function setBooker(?User $booker): self
    {
        $this->booker = $booker;

        return $this;
    }

    public function getBookingDate(): ?\DateTimeImmutable
    {
        return $this->bookingDate;
    }

    public function setBookingDate(\DateTimeImmutable $bookingDate): self
    {
        $this->bookingDate = $bookingDate;

        return $this;
    }

    public function getListing(): ?Listing
    {
        return $this->listing;
    }

    public function setListing(?Listing $listing): self
    {
        $this->listing = $listing;

        return $this;
    }

    public function getPayed(): ?bool
    {
        return $this->payed;
    }

    public function setPayed(bool $payed): self
    {
        $this->payed = $payed;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

}
