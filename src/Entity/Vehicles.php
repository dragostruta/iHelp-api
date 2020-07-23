<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VehiclesRepository")
 */
class Vehicles
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $licensePlate;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\ParkingSpot", mappedBy="vehicle", cascade={"persist", "remove"})
     */
    private $parkingSpot;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getLicensePlate(): ?string
    {
        return $this->licensePlate;
    }

    public function setLicensePlate(string $licensePlate): self
    {
        $this->licensePlate = $licensePlate;

        return $this;
    }

    public function getParkingSpot(): ?ParkingSpot
    {
        return $this->parkingSpot;
    }

    public function setParkingSpot(ParkingSpot $parkingSpot): self
    {
        $this->parkingSpot = $parkingSpot;

        // set the owning side of the relation if necessary
        if ($this !== $parkingSpot->getVehicle()) {
            $parkingSpot->setVehicle($this);
        }

        return $this;
    }
}
