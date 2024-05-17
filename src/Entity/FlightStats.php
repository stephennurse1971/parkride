<?php

namespace App\Entity;

use App\Repository\FlightStatsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FlightStatsRepository::class)
 */
class FlightStats
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $flightFrom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $flightTo;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $lowestPrice;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $scrapeDate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getFlightFrom(): ?string
    {
        return $this->flightFrom;
    }

    public function setFlightFrom(string $flightFrom): self
    {
        $this->flightFrom = $flightFrom;

        return $this;
    }

    public function getFlightTo(): ?string
    {
        return $this->flightTo;
    }

    public function setFlightTo(?string $flightTo): self
    {
        $this->flightTo = $flightTo;

        return $this;
    }

    public function getLowestPrice(): ?float
    {
        return $this->lowestPrice;
    }

    public function setLowestPrice(?float $lowestPrice): self
    {
        $this->lowestPrice = $lowestPrice;

        return $this;
    }

    public function getScrapeDate(): ?\DateTimeInterface
    {
        return $this->scrapeDate;
    }

    public function setScrapeDate(?\DateTimeInterface $scrapeDate): self
    {
        $this->scrapeDate = $scrapeDate;

        return $this;
    }
}
