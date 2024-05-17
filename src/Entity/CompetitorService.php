<?php

namespace App\Entity;

use App\Repository\CompetitorServiceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CompetitorServiceRepository::class)
 */
class CompetitorService
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Competitors::class)
     */
    private $competitor;

    /**
     * @ORM\ManyToOne(targetEntity=ServicesOffered::class)
     */
    private $service;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $price;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompetitor(): ?Competitors
    {
        return $this->competitor;
    }

    public function setCompetitor(?Competitors $competitor): self
    {
        $this->competitor = $competitor;

        return $this;
    }

    public function getService(): ?ServicesOffered
    {
        return $this->service;
    }

    public function setService(?ServicesOffered $service): self
    {
        $this->service = $service;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;

        return $this;
    }
}
