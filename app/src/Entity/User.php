<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity()
 * @ORM\Table(name="users")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{

    private const ROLE_USER = 'ROLE_USER';

    /**
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     * @ORM\Id()
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $email;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $password;

    /**
     * @var array
     * @ORM\Column(type="json", nullable=false)
     */
    private $roles = [self::ROLE_USER];

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Listing", mappedBy="provider", orphanRemoval=true)
     */
    private $listings;

    /**
     * @ORM\Embedded(class="App\Entity\Address")
     */
    private $address;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;

    public function __construct(string $email)
    {
        $this->email = $email;
        $this->listings = new ArrayCollection();
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getSalt()
    {
        return null;
    }

    public function getUsername()
    {
        return $this->email;
    }

    public function eraseCredentials()
    {
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return User
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Collection|Listing[]
     */
    public function getListings(): Collection
    {
        return $this->listings;
    }

    public function addListing(Listing $listing): self
    {
        if (!$this->listings->contains($listing)) {
            $this->listings[] = $listing;
            $listing->setProvider($this);
        }

        return $this;
    }

    public function removeListing(Listing $listing): self
    {
        if ($this->listings->contains($listing)) {
            $this->listings->removeElement($listing);
            // set the owning side to null (unless already changed)
            if ($listing->getProvider() === $this) {
                $listing->setProvider(null);
            }
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address): void
    {
        $this->address = $address;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    /**
     * @param array $roles
     */
    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    /**
     * @param ArrayCollection $listings
     */
    public function setListings(ArrayCollection $listings): void
    {
        $this->listings = $listings;
    }

}