<?php

namespace App\Entity;

use App\Repository\DocumentGuidelinesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DocumentGuidelinesRepository::class)
 */
class DocumentGuidelines
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $document;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $guidelines;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDocument(): ?string
    {
        return $this->document;
    }

    public function setDocument(?string $document): self
    {
        $this->document = $document;

        return $this;
    }

    public function getGuidelines(): ?string
    {
        return $this->guidelines;
    }

    public function setGuidelines(?string $guidelines): self
    {
        $this->guidelines = $guidelines;

        return $this;
    }
}
