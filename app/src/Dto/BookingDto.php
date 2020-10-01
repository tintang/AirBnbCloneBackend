<?php


namespace App\Dto;


class BookingDto
{

    private ?int $listing = null;

    /**
     * @param string|null $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    /**
     * @param string|null $price
     */
    public function setPrice(?string $price): void
    {
        $this->price = $price;
    }

    /**
     * @return int|null
     */
    public function getListing(): ?int
    {
        return $this->listing;
    }

    /**
     * @param int|null $listing
     */
    public function setListing(?int $listing): void
    {
        $this->listing = $listing;
    }

}