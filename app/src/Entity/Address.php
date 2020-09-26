<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Class Address
 * @package App\Entity
 * @ORM\Embeddable()
 */
class Address
{
    /**
     * @var string
     * @ORM\Column(type="string", length=80)
     */
    private $street;

    /**
     * @var string
     * @ORM\Column(type="string", length=80)
     */
    private $extendedStreet;

    /**
     * @var string
     * @ORM\Column(type="string", length=100)
     */
    private $city;

    /**
     * @var string
     * @ORM\Column(type="string", length=15)
     */
    private $zipCode;

    /**
     * @var string
     * @ORM\Column(type="string", length=3)
     */
    private $country;

    /**
     * @return string
     */
    public function getStreet(): ?string
    {
        return $this->street;
    }

    /**
     * @param string $street
     */
    public function setStreet(string $street): void
    {
        $this->street = $street;
    }

    /**
     * @return string
     */
    public function getExtendedStreet(): ?string
    {
        return $this->extendedStreet;
    }

    /**
     * @param string $extendedStreet
     */
    public function setExtendedStreet(string $extendedStreet): void
    {
        $this->extendedStreet = $extendedStreet;
    }

    /**
     * @return string
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    /**
     * @param string $zipCode
     */
    public function setZipCode(string $zipCode): void
    {
        $this->zipCode = $zipCode;
    }

    /**
     * @return string
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

}