<?php

namespace App\Traits;

trait AddressTrait
{


    private ?string $street = null;

    private ?string $extendedStreet = null;

    private ?string $city = null;

    private ?string $zipCode = null;

    private ?string $country = null;

    /**
     * @return string|null
     */
    public function getStreet(): ?string
    {
        return $this->street;
    }

    /**
     * @param string|null $street
     */
    public function setStreet(?string $street): void
    {
        $this->street = $street;
    }

    /**
     * @return string|null
     */
    public function getExtendedStreet(): ?string
    {
        return $this->extendedStreet;
    }

    /**
     * @param string|null $extendedStreet
     */
    public function setExtendedStreet(?string $extendedStreet): void
    {
        $this->extendedStreet = $extendedStreet;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string|null $city
     */
    public function setCity(?string $city): void
    {
        $this->city = $city;
    }

    /**
     * @return string|null
     */
    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    /**
     * @param string|null $zipCode
     */
    public function setZipCode(?string $zipCode): void
    {
        $this->zipCode = $zipCode;
    }

    /**
     * @return string|null
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @param string|null $country
     */
    public function setCountry(?string $country): void
    {
        $this->country = $country;
    }
}