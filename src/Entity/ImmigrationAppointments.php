<?php

namespace App\Entity;

use App\Repository\ImmigrationAppointmentsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ImmigrationAppointmentsRepository::class)
 */
class ImmigrationAppointments
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;



    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private $chaperone;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private $client;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $time;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $calendarInvite;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $calendarReceipt;

    public function getId(): ?int
    {
        return $this->id;
    }



    public function getChaperone(): ?User
    {
        return $this->chaperone;
    }

    public function setChaperone(?User $chaperone): self
    {
        $this->chaperone = $chaperone;

        return $this;
    }

    public function getClient(): ?User
    {
        return $this->client;
    }

    public function setClient(?User $client): self
    {
        $this->client = $client;

        return $this;
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

    public function getTime(): ?int
    {
        return $this->time;
    }

    public function setTime(?int $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getCalendarInvite(): ?string
    {
        return $this->calendarInvite;
    }

    public function setCalendarInvite(?string $calendarInvite): self
    {
        $this->calendarInvite = $calendarInvite;

        return $this;
    }

    public function getCalendarReceipt(): ?string
    {
        return $this->calendarReceipt;
    }

    public function setCalendarReceipt(?string $calendarReceipt): self
    {
        $this->calendarReceipt = $calendarReceipt;

        return $this;
    }
}
