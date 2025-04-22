<?php

namespace App\Entity;

use App\Repository\OfficeRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Users;
use App\Entity\HorairesDispo;

#[ORM\Entity(repositoryClass: OfficeRepository::class)]
class Office
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $businessName = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $siret = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $registrationDocument = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $websiteLink = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $officeAddress = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $officePhone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $profilePicture = null;

    #[ORM\Column(type: "text", nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: "float", nullable: true)]
    private ?float $latitude = null;

    #[ORM\Column(type: "float", nullable: true)]
    private ?float $longitude = null;

    #[ORM\Column(type: "integer", options: ["default" => 0])]
    private ?int $points = 0;

    #[ORM\Column(type: "boolean", options: ["default" => false])]
    private ?bool $vip = false;

    #[ORM\Column(length: 20, options: ["default" => "pending"])]
    private ?string $status = 'pending';

    #[ORM\ManyToOne(inversedBy: 'offices')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $user = null;

    /* #[ORM\ManyToOne(targetEntity: HorairesDispo::class)]
    private ?HorairesDispo $availabilitySchedule = null; */

    // === Getters & Setters ===

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBusinessName(): ?string
    {
        return $this->businessName;
    }

    public function setBusinessName(string $businessName): static
    {
        $this->businessName = $businessName;

        return $this;
    }

    public function getSiret(): ?string
    {
        return $this->siret;
    }

    public function setSiret(?string $siret): static
    {
        $this->siret = $siret;

        return $this;
    }

    public function getRegistrationDocument(): ?string
    {
        return $this->registrationDocument;
    }

    public function setRegistrationDocument(?string $registrationDocument): static
    {
        $this->registrationDocument = $registrationDocument;

        return $this;
    }

    public function getWebsiteLink(): ?string
    {
        return $this->websiteLink;
    }

    public function setWebsiteLink(?string $websiteLink): static
    {
        $this->websiteLink = $websiteLink;

        return $this;
    }

    public function getOfficeAddress(): ?string
    {
        return $this->officeAddress;
    }

    public function setOfficeAddress(?string $officeAddress): static
    {
        $this->officeAddress = $officeAddress;

        return $this;
    }

    public function getOfficePhone(): ?string
    {
        return $this->officePhone;
    }

    public function setOfficePhone(?string $officePhone): static
    {
        $this->officePhone = $officePhone;

        return $this;
    }

    public function getProfilePicture(): ?string
    {
        return $this->profilePicture;
    }

    public function setProfilePicture(?string $profilePicture): static
    {
        $this->profilePicture = $profilePicture;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): static
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): static
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getPoints(): ?int
    {
        return $this->points;
    }

    public function setPoints(?int $points): static
    {
        $this->points = $points;

        return $this;
    }

    public function isVip(): ?bool
    {
        return $this->vip;
    }

    public function setVip(?bool $vip): static
    {
        $this->vip = $vip;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): static
    {
        $this->user = $user;

        return $this;
    }

    /* public function getAvailabilitySchedule(): ?HorairesDispo
    {
        return $this->availabilitySchedule;
    }

    public function setAvailabilitySchedule(?HorairesDispo $availabilitySchedule): static
    {
        $this->availabilitySchedule = $availabilitySchedule;

        return $this;
    } */
}
