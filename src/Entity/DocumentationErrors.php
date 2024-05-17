<?php

namespace App\Entity;

use App\Repository\DocumentationErrorsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DocumentationErrorsRepository::class)
 */
class DocumentationErrors
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
    private $summaryCheckBox;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $remedy;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $document;

    public function getId(): ?int
    {
        return $this->id;
    }



    public function getSummaryCheckBox(): ?string
    {
        return $this->summaryCheckBox;
    }

    public function setSummaryCheckBox(?string $summaryCheckBox): self
    {
        $this->summaryCheckBox = $summaryCheckBox;

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

    public function getRemedy(): ?string
    {
        return $this->remedy;
    }

    public function setRemedy(?string $remedy): self
    {
        $this->remedy = $remedy;

        return $this;
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
}
