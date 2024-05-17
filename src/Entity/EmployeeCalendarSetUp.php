<?php

namespace App\Entity;

use App\Repository\EmployeeCalendarSetUpRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EmployeeCalendarSetUpRepository::class)
 */
class EmployeeCalendarSetUp
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
    private $startDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $endDate;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private $employee;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $dayOfWeek = [];

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $startTime;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $endTime;

    public function getId(): ?int
    {
        return $this->id;
    }




    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getEmployee(): ?User
    {
        return $this->employee;
    }

    public function setEmployee(?User $employee): self
    {
        $this->employee = $employee;

        return $this;
    }

    public function getDayOfWeek(): ?array
    {
        return $this->dayOfWeek;
    }

    public function setDayOfWeek(?array $dayOfWeek): self
    {
        $this->dayOfWeek = $dayOfWeek;

        return $this;
    }

    public function getStartTime(): ?int
    {
        return $this->startTime;
    }

    public function setStartTime(?int $startTime): self
    {
        $this->startTime = $startTime;

        return $this;
    }

    public function getEndTime(): ?int
    {
        return $this->endTime;
    }

    public function setEndTime(?int $endTime): self
    {
        $this->endTime = $endTime;

        return $this;
    }
}
