<?php

namespace App\Entity;

use App\Repository\SettingsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SettingsRepository::class)
 */
class Settings
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $flightStatsDays;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $flightStatsStartDate;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFlightStatsDays(): ?int
    {
        return $this->flightStatsDays;
    }

    public function setFlightStatsDays(?int $flightStatsDays): self
    {
        $this->flightStatsDays = $flightStatsDays;

        return $this;
    }

    public function getFlightStatsStartDate(): ?\DateTimeInterface
    {
        return $this->flightStatsStartDate;
    }

    public function setFlightStatsStartDate(?\DateTimeInterface $flightStatsStartDate): self
    {
        $this->flightStatsStartDate = $flightStatsStartDate;

        return $this;
    }


}
