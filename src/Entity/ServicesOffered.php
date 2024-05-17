<?php

namespace App\Entity;

use App\Repository\ServicesOfferedRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ServicesOfferedRepository::class)
 */
class ServicesOffered
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
    private $serviceOffered;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $serviceArea;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $docsPassport;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $docsTenancyAgreement;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $docsUtilityBill;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $docsEmploymentContract;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $docsFinancialStatements;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $docsP60;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $docsSchoolAttendanceCertificate;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $docsCriminalRecordCheck;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $docsHealthInsurance;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $docsMedical;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $docsDrivingLicense;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $price;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $ranking;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $priceUpfront;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comments;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $docsBirthMarriageDeathCertificate;



    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $includeInFooter;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $requiresImmigrationAppointment;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $officialForm;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getServiceOffered(): ?string
    {
        return $this->serviceOffered;
    }

    public function setServiceOffered(?string $serviceOffered): self
    {
        $this->serviceOffered = $serviceOffered;

        return $this;
    }

    public function getServiceArea(): ?string
    {
        return $this->serviceArea;
    }

    public function setServiceArea(?string $serviceArea): self
    {
        $this->serviceArea = $serviceArea;

        return $this;
    }

    public function isDocsPassport(): ?bool
    {
        return $this->docsPassport;
    }

    public function setDocsPassport(?bool $docsPassport): self
    {
        $this->docsPassport = $docsPassport;

        return $this;
    }

    public function isDocsTenancyAgreement(): ?bool
    {
        return $this->docsTenancyAgreement;
    }

    public function setDocsTenancyAgreement(?bool $docsTenancyAgreement): self
    {
        $this->docsTenancyAgreement = $docsTenancyAgreement;

        return $this;
    }

    public function isDocsUtilityBill(): ?bool
    {
        return $this->docsUtilityBill;
    }

    public function setDocsUtilityBill(?bool $docsUtilityBill): self
    {
        $this->docsUtilityBill = $docsUtilityBill;

        return $this;
    }

    public function isDocsEmploymentContract(): ?bool
    {
        return $this->docsEmploymentContract;
    }

    public function setDocsEmploymentContract(?bool $docsEmploymentContract): self
    {
        $this->docsEmploymentContract = $docsEmploymentContract;

        return $this;
    }

    public function isDocsFinancialStatements(): ?bool
    {
        return $this->docsFinancialStatements;
    }

    public function setDocsFinancialStatements(?bool $docsFinancialStatements): self
    {
        $this->docsFinancialStatements = $docsFinancialStatements;

        return $this;
    }

    public function isDocsP60(): ?bool
    {
        return $this->docsP60;
    }

    public function setDocsP60(?bool $docsP60): self
    {
        $this->docsP60 = $docsP60;

        return $this;
    }

    public function isDocsSchoolAttendanceCertificate(): ?bool
    {
        return $this->docsSchoolAttendanceCertificate;
    }

    public function setDocsSchoolAttendanceCertificate(?bool $docsSchoolAttendanceCertificate): self
    {
        $this->docsSchoolAttendanceCertificate = $docsSchoolAttendanceCertificate;

        return $this;
    }

    public function isDocsCriminalRecordCheck(): ?bool
    {
        return $this->docsCriminalRecordCheck;
    }

    public function setDocsCriminalRecordCheck(?bool $docsCriminalRecordCheck): self
    {
        $this->docsCriminalRecordCheck = $docsCriminalRecordCheck;

        return $this;
    }

    public function isDocsHealthInsurance(): ?bool
    {
        return $this->docsHealthInsurance;
    }

    public function setDocsHealthInsurance(?bool $docsHealthInsurance): self
    {
        $this->docsHealthInsurance = $docsHealthInsurance;

        return $this;
    }

    public function isDocsMedical(): ?bool
    {
        return $this->docsMedical;
    }

    public function setDocsMedical(?bool $docsMedical): self
    {
        $this->docsMedical = $docsMedical;

        return $this;
    }

    public function isDocsDrivingLicense(): ?bool
    {
        return $this->docsDrivingLicense;
    }

    public function setDocsDrivingLicense(?bool $docsDrivingLicense): self
    {
        $this->docsDrivingLicense = $docsDrivingLicense;

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

    public function getRanking(): ?int
    {
        return $this->ranking;
    }

    public function setRanking(?int $ranking): self
    {
        $this->ranking = $ranking;

        return $this;
    }

    public function getPriceUpfront(): ?int
    {
        return $this->priceUpfront;
    }

    public function setPriceUpfront(?int $priceUpfront): self
    {
        $this->priceUpfront = $priceUpfront;

        return $this;
    }

    public function getComments(): ?string
    {
        return $this->comments;
    }

    public function setComments(?string $comments): self
    {
        $this->comments = $comments;

        return $this;
    }

    public function isDocsBirthMarriageDeathCertificate(): ?bool
    {
        return $this->docsBirthMarriageDeathCertificate;
    }

    public function setDocsBirthMarriageDeathCertificate(?bool $docsBirthMarriageDeathCertificate): self
    {
        $this->docsBirthMarriageDeathCertificate = $docsBirthMarriageDeathCertificate;

        return $this;
    }



    public function isIncludeInFooter(): ?bool
    {
        return $this->includeInFooter;
    }

    public function setIncludeInFooter(?bool $includeInFooter): self
    {
        $this->includeInFooter = $includeInFooter;

        return $this;
    }

    public function isRequiresImmigrationAppointment(): ?bool
    {
        return $this->requiresImmigrationAppointment;
    }

    public function setRequiresImmigrationAppointment(?bool $requiresImmigrationAppointment): self
    {
        $this->requiresImmigrationAppointment = $requiresImmigrationAppointment;

        return $this;
    }

    public function getOfficialForm(): ?string
    {
        return $this->officialForm;
    }

    public function setOfficialForm(?string $officialForm): self
    {
        $this->officialForm = $officialForm;

        return $this;
    }
}
