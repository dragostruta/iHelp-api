<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ParkingPlaceRepository")
 */
class ParkingPlace implements \Countable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Zone")
     * @ORM\JoinColumn(nullable=false)
     */
    private $zone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $numberParkingSpotsTotal;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $numberParkingSpotsFree;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $pricePerHour;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $currency;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getZone(): ?Zone
    {
        return $this->zone;
    }

    public function setZone(?Zone $zone): self
    {
        $this->zone = $zone;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getNumberParkingSpotsTotal(): ?int
    {
        return $this->numberParkingSpotsTotal;
    }

    public function setNumberParkingSpotsTotal(?int $numberParkingSpotsTotal): self
    {
        $this->numberParkingSpotsTotal = $numberParkingSpotsTotal;

        return $this;
    }

    public function getNumberParkingSpotsFree(): ?int
    {
        return $this->numberParkingSpotsFree;
    }

    public function setNumberParkingSpotsFree(?int $numberParkingSpotsFree): self
    {
        $this->numberParkingSpotsFree = $numberParkingSpotsFree;

        return $this;
    }

    public function getPricePerHour(): ?int
    {
        return $this->pricePerHour;
    }

    public function setPricePerHour(?int $pricePerHour): self
    {
        $this->pricePerHour = $pricePerHour;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function count()
    {
        // TODO: Implement count() method.
    }
}
