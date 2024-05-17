<?php

namespace App\Entity;

use App\Repository\OfficeAppointmentsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OfficeAppointmentsRepository::class)
 */
class OfficeAppointments
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
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private $staff;

    /**
     * @ORM\Column(type="integer")
     */
    private $time;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $calendarInvite;

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


    public function getClient(): ?User
    {
        return $this->client;
    }

    public function setClient(?User $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getStaff(): ?User
    {
        return $this->staff;
    }

    public function setStaff(?User $staff): self
    {
        $this->staff = $staff;

        return $this;
    }

    public function getTime(): ?int
    {
        return $this->time;
    }

    public function setTime(int $time): self
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
}
