<?php

namespace App\Entity;

use App\Repository\CmsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CmsRepository::class)
 */
class Cms
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
    private $companyEmail;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $companyTel;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $companyAddress;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $cms1EN;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $cms2EN;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $cms3EN;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $cms4EN;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $facebook;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $linkedIn;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $addressGpsLocation;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $addressInstructions;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $twitter;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $instagram;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $companyName;



    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $footerText;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $companyMobile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $companyAddressCity;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $companyAddressPostalCode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $companyAddressCountry;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompanyEmail(): ?string
    {
        return $this->companyEmail;
    }

    public function setCompanyEmail(?string $companyEmail): self
    {
        $this->companyEmail = $companyEmail;

        return $this;
    }

    public function getCompanyTel(): ?string
    {
        return $this->companyTel;
    }

    public function setCompanyTel(string $companyTel): self
    {
        $this->companyTel = $companyTel;

        return $this;
    }

    public function getCompanyAddress(): ?string
    {
        return $this->companyAddress;
    }

    public function setCompanyAddress(?string $companyAddress): self
    {
        $this->companyAddress = $companyAddress;

        return $this;
    }

    public function getCms1EN(): ?string
    {
        return $this->cms1EN;
    }

    public function setCms1EN(?string $cms1EN): self
    {
        $this->cms1EN = $cms1EN;

        return $this;
    }

    public function getCms2EN(): ?string
    {
        return $this->cms2EN;
    }

    public function setCms2EN(?string $cms2EN): self
    {
        $this->cms2EN = $cms2EN;

        return $this;
    }

    public function getCms3EN(): ?string
    {
        return $this->cms3EN;
    }

    public function setCms3EN(?string $cms3EN): self
    {
        $this->cms3EN = $cms3EN;

        return $this;
    }

    public function getCms4EN(): ?string
    {
        return $this->cms4EN;
    }

    public function setCms4EN(?string $cms4EN): self
    {
        $this->cms4EN = $cms4EN;

        return $this;
    }

    public function getFacebook(): ?string
    {
        return $this->facebook;
    }

    public function setFacebook(?string $facebook): self
    {
        $this->facebook = $facebook;

        return $this;
    }

    public function getLinkedIn(): ?string
    {
        return $this->linkedIn;
    }

    public function setLinkedIn(?string $linkedIn): self
    {
        $this->linkedIn = $linkedIn;

        return $this;
    }

    public function getAddressGpsLocation(): ?string
    {
        return $this->addressGpsLocation;
    }

    public function setAddressGpsLocation(string $addressGpsLocation): self
    {
        $this->addressGpsLocation = $addressGpsLocation;

        return $this;
    }

    public function getAddressInstructions(): ?string
    {
        return $this->addressInstructions;
    }

    public function setAddressInstructions(?string $addressInstructions): self
    {
        $this->addressInstructions = $addressInstructions;

        return $this;
    }

    public function getTwitter(): ?string
    {
        return $this->twitter;
    }

    public function setTwitter(?string $twitter): self
    {
        $this->twitter = $twitter;

        return $this;
    }

    public function getInstagram(): ?string
    {
        return $this->instagram;
    }

    public function setInstagram(?string $instagram): self
    {
        $this->instagram = $instagram;

        return $this;
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function setCompanyName(?string $companyName): self
    {
        $this->companyName = $companyName;

        return $this;
    }



    public function getFooterText(): ?string
    {
        return $this->footerText;
    }

    public function setFooterText(?string $footerText): self
    {
        $this->footerText = $footerText;

        return $this;
    }

    public function getCompanyMobile(): ?string
    {
        return $this->companyMobile;
    }

    public function setCompanyMobile(?string $companyMobile): self
    {
        $this->companyMobile = $companyMobile;

        return $this;
    }

    public function getCompanyAddressCity(): ?string
    {
        return $this->companyAddressCity;
    }

    public function setCompanyAddressCity(?string $companyAddressCity): self
    {
        $this->companyAddressCity = $companyAddressCity;

        return $this;
    }

    public function getCompanyAddressPostalCode(): ?string
    {
        return $this->companyAddressPostalCode;
    }

    public function setCompanyAddressPostalCode(?string $companyAddressPostalCode): self
    {
        $this->companyAddressPostalCode = $companyAddressPostalCode;

        return $this;
    }

    public function getCompanyAddressCountry(): ?string
    {
        return $this->companyAddressCountry;
    }

    public function setCompanyAddressCountry(?string $companyAddressCountry): self
    {
        $this->companyAddressCountry = $companyAddressCountry;

        return $this;
    }
}
