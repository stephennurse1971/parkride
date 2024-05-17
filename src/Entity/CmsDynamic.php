<?php

namespace App\Entity;

use App\Repository\CmsDynamicRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CmsDynamicRepository::class)
 */
class CmsDynamic
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
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $titleFR;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $titleDE;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $titleES;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $para1;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $para1FR;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $para1DE;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $para1ES;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $para2;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $para2FR;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $para2DE;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $para2ES;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $para3;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $para3FR;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $para3DE;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $para3ES;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $para4;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $para4FR;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $para4DE;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $para4ES;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $para5;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $para5FR;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $para5DE;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $para5ES;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $para6;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $para6FR;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $para6DE;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $para6ES;

    /**
     * @ORM\OneToOne(targetEntity=ServicesOffered::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $webpage;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $articlePage;

    public function getId(): ?int
    {
        return $this->id;
    }



    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getTitleFR(): ?string
    {
        return $this->titleFR;
    }

    public function setTitleFR(?string $titleFR): self
    {
        $this->titleFR = $titleFR;

        return $this;
    }

    public function getTitleDE(): ?string
    {
        return $this->titleDE;
    }

    public function setTitleDE(?string $titleDE): self
    {
        $this->titleDE = $titleDE;

        return $this;
    }

    public function getTitleES(): ?string
    {
        return $this->titleES;
    }

    public function setTitleES(?string $titleES): self
    {
        $this->titleES = $titleES;

        return $this;
    }

    public function getPara1(): ?string
    {
        return $this->para1;
    }

    public function setPara1(?string $para1): self
    {
        $this->para1 = $para1;

        return $this;
    }

    public function getPara1FR(): ?string
    {
        return $this->para1FR;
    }

    public function setPara1FR(?string $para1FR): self
    {
        $this->para1FR = $para1FR;

        return $this;
    }

    public function getPara1DE(): ?string
    {
        return $this->para1DE;
    }

    public function setPara1DE(?string $para1DE): self
    {
        $this->para1DE = $para1DE;

        return $this;
    }

    public function getPara1ES(): ?string
    {
        return $this->para1ES;
    }

    public function setPara1ES(?string $para1ES): self
    {
        $this->para1ES = $para1ES;

        return $this;
    }

    public function getPara2(): ?string
    {
        return $this->para2;
    }

    public function setPara2(?string $para2): self
    {
        $this->para2 = $para2;

        return $this;
    }

    public function getPara2FR(): ?string
    {
        return $this->para2FR;
    }

    public function setPara2FR(?string $para2FR): self
    {
        $this->para2FR = $para2FR;

        return $this;
    }

    public function getPara2DE(): ?string
    {
        return $this->para2DE;
    }

    public function setPara2DE(?string $para2DE): self
    {
        $this->para2DE = $para2DE;

        return $this;
    }

    public function getPara2ES(): ?string
    {
        return $this->para2ES;
    }

    public function setPara2ES(?string $para2ES): self
    {
        $this->para2ES = $para2ES;

        return $this;
    }

    public function getPara3(): ?string
    {
        return $this->para3;
    }

    public function setPara3(?string $para3): self
    {
        $this->para3 = $para3;

        return $this;
    }

    public function getPara3FR(): ?string
    {
        return $this->para3FR;
    }

    public function setPara3FR(?string $para3FR): self
    {
        $this->para3FR = $para3FR;

        return $this;
    }

    public function getPara3DE(): ?string
    {
        return $this->para3DE;
    }

    public function setPara3DE(?string $para3DE): self
    {
        $this->para3DE = $para3DE;

        return $this;
    }

    public function getPara3ES(): ?string
    {
        return $this->para3ES;
    }

    public function setPara3ES(?string $para3ES): self
    {
        $this->para3ES = $para3ES;

        return $this;
    }

    public function getPara4(): ?string
    {
        return $this->para4;
    }

    public function setPara4(?string $para4): self
    {
        $this->para4 = $para4;

        return $this;
    }

    public function getPara4FR(): ?string
    {
        return $this->para4FR;
    }

    public function setPara4FR(?string $para4FR): self
    {
        $this->para4FR = $para4FR;

        return $this;
    }

    public function getPara4DE(): ?string
    {
        return $this->para4DE;
    }

    public function setPara4DE(?string $para4DE): self
    {
        $this->para4DE = $para4DE;

        return $this;
    }

    public function getPara4ES(): ?string
    {
        return $this->para4ES;
    }

    public function setPara4ES(?string $para4ES): self
    {
        $this->para4ES = $para4ES;

        return $this;
    }

    public function getPara5(): ?string
    {
        return $this->para5;
    }

    public function setPara5(?string $para5): self
    {
        $this->para5 = $para5;

        return $this;
    }

    public function getPara5FR(): ?string
    {
        return $this->para5FR;
    }

    public function setPara5FR(?string $para5FR): self
    {
        $this->para5FR = $para5FR;

        return $this;
    }

    public function getPara5DE(): ?string
    {
        return $this->para5DE;
    }

    public function setPara5DE(string $para5DE): self
    {
        $this->para5DE = $para5DE;

        return $this;
    }

    public function getPara5ES(): ?string
    {
        return $this->para5ES;
    }

    public function setPara5ES(?string $para5ES): self
    {
        $this->para5ES = $para5ES;

        return $this;
    }

    public function getPara6(): ?string
    {
        return $this->para6;
    }

    public function setPara6(?string $para6): self
    {
        $this->para6 = $para6;

        return $this;
    }

    public function getPara6FR(): ?string
    {
        return $this->para6FR;
    }

    public function setPara6FR(?string $para6FR): self
    {
        $this->para6FR = $para6FR;

        return $this;
    }

    public function getPara6DE(): ?string
    {
        return $this->para6DE;
    }

    public function setPara6DE(?string $para6DE): self
    {
        $this->para6DE = $para6DE;

        return $this;
    }

    public function getPara6ES(): ?string
    {
        return $this->para6ES;
    }

    public function setPara6ES(?string $para6ES): self
    {
        $this->para6ES = $para6ES;

        return $this;
    }

    public function getWebpage(): ?ServicesOffered
    {
        return $this->webpage;
    }

    public function setWebpage(?ServicesOffered $webpage): self
    {
        $this->webpage = $webpage;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getArticlePage(): ?string
    {
        return $this->articlePage;
    }

    public function setArticlePage(?string $articlePage): self
    {
        $this->articlePage = $articlePage;

        return $this;
    }
}
