<?php

namespace App\Entity;

use App\Enum\statusEnum;
use App\Repository\OfficeRepository;

use App\Traits\TimestampableTrait;   //pour createAt et updateAt auto
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection; 

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: OfficeRepository::class)]
class Office
{
    use TimestampableTrait;   //pour createAt et updateAt auto

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $businessName = null;

    #[ORM\Column(length: 20)]
    private ?string $siret = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $businessProof = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $personalSiteLink = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $profilePhotoLink = null;

    #[ORM\Column(length: 20)]
    private ?string $officePhone = null;

    #[ORM\Column(length: 10)]
    private ?string $officeStreetNumber = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $officeStreetName = null;

    #[ORM\Column(length: 255)]
    private ?string $officeAddress = null;

    #[ORM\Column]
    private ?int $officePostalCode = null;

    #[ORM\Column(length: 30)]
    private ?string $officeCity = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $officeCountry = null;

    #[ORM\Column]
    private ?float $officeLatitude = null;

    #[ORM\Column]
    private ?float $officeLongitude = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column( nullable: true)]
    private ?int $score = null;

    #[ORM\Column( nullable: true)]
    private ?bool $vip = null;

    #[ORM\Column(enumType: statusEnum::class)]
    private ?statusEnum $status = null;

    #[ORM\ManyToOne(inversedBy: 'offices')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    /**
     * @var Collection<int, OfficePhoto>
     */
    #[ORM\OneToMany(targetEntity: OfficePhoto::class, mappedBy: 'office', orphanRemoval: true)]
    private Collection $officePhotos;

    /**
     * @var Collection<int, TimeConfiguration>
     */
    #[ORM\OneToMany(targetEntity: TimeConfiguration::class, mappedBy: 'office', orphanRemoval: true)]
    private Collection $timeConfigurations;

    /**
     * @var Collection<int, Profession>
     */
    #[ORM\ManyToMany(targetEntity: Profession::class, mappedBy: 'office')]
    private Collection $professions;

    /**
     * @var Collection<int, Profession>
     */
    #[ORM\ManyToMany(targetEntity: Profession::class, inversedBy: 'offices')]
    private Collection $profession;

    /**
     * @var Collection<int, OfficeTypeOfService>
     */
    #[ORM\ManyToMany(targetEntity: OfficeTypeOfService::class, mappedBy: 'office')]
    private Collection $officeTypeOfServices;

    /**
     * @var Collection<int, Rdv>
     */
    #[ORM\OneToMany(targetEntity: Rdv::class, mappedBy: 'office', orphanRemoval: true)]
    private Collection $rdvs;

    /**
     * @var Collection<int, OfficeClosure>
     */
    #[ORM\OneToMany(targetEntity: OfficeClosure::class, mappedBy: 'office', orphanRemoval: true)]
    private Collection $officeClosures;

    /**
     * @var Collection<int, Review>
     */
    #[ORM\OneToMany(targetEntity: Review::class, mappedBy: 'office', orphanRemoval: true)]
    private Collection $reviews;


    public function __construct()
    {
        $this->officePhotos = new ArrayCollection();
        $this->timeConfigurations = new ArrayCollection();
        $this->professions = new ArrayCollection();
        $this->profession = new ArrayCollection();
        $this->officeTypeOfServices = new ArrayCollection();
        $this->rdvs = new ArrayCollection();
        $this->officeClosures = new ArrayCollection();
        $this->reviews = new ArrayCollection();
    }


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

    public function setSiret(string $siret): static
    {
        $this->siret = $siret;

        return $this;
    }

    public function getBusinessProof(): ?string
    {
        return $this->businessProof;
    }

    public function setBusinessProof(?string $businessProof): static
    {
        $this->businessProof = $businessProof;

        return $this;
    }

    public function getPersonalSiteLink(): ?string
    {
        return $this->personalSiteLink;
    }

    public function setPersonalSiteLink(?string $personalSiteLink): static
    {
        $this->personalSiteLink = $personalSiteLink;

        return $this;
    }

    public function getProfilePhotoLink(): ?string
    {
        return $this->profilePhotoLink;
    }

    public function setProfilePhotoLink(?string $profilePhotoLink): static
    {
        $this->profilePhotoLink = $profilePhotoLink;

        return $this;
    }

    public function getOfficePhone(): ?string
    {
        return $this->officePhone;
    }

    public function setOfficePhone(string $officePhone): static
    {
        $this->officePhone = $officePhone;

        return $this;
    }

    public function getOfficeStreetNumber(): ?string
    {
        return $this->officeStreetNumber;
    }

    public function setOfficeStreetNumber(string $officeStreetNumber): static
    {
        $this->officeStreetNumber = $officeStreetNumber;

        return $this;
    }

    public function getOfficeAddress(): ?string
    {
        return $this->officeAddress;
    }

    public function setOfficeAddress(string $officeAddress): static
    {
        $this->officeAddress = $officeAddress;

        return $this;
    }

    public function getOfficePostalCode(): ?int
    {
        return $this->officePostalCode;
    }

    public function setOfficePostalCode(int $officePostalCode): static
    {
        $this->officePostalCode = $officePostalCode;

        return $this;
    }

    public function getOfficeCity(): ?string
    {
        return $this->officeCity;
    }

    public function setOfficeCity(string $officeCity): static
    {
        $this->officeCity = $officeCity;

        return $this;
    }

    public function getOfficeCountry(): ?string
    {
        return $this->officeCountry;
    }

    public function setOfficeCountry(string $officeCountry): static
    {
        $this->officeCountry = $officeCountry;

        return $this;
    }

    public function getOfficeLatitude(): ?float
    {
        return $this->officeLatitude;
    }

    public function setOfficeLatitude(float $officeLatitude): static
    {
        $this->officeLatitude = $officeLatitude;

        return $this;
    }

    public function getOfficeLongitude(): ?float
    {
        return $this->officeLongitude;
    }

    public function setOfficeLongitude(float $officeLongitude): static
    {
        $this->officeLongitude = $officeLongitude;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): static
    {
        $this->score = $score;

        return $this;
    }

    public function isVip(): ?bool
    {
        return $this->vip;
    }

    public function setVip(bool $vip): static
    {
        $this->vip = $vip;

        return $this;
    }

    public function getStatus(): ?statusEnum
    {
        return $this->status;
    }

    public function setStatus(statusEnum $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->user;
    }

    public function setUserId(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, OfficePhoto>
     */
    public function getOfficePhotos(): Collection
    {
        return $this->officePhotos;
    }

    public function addOfficePhoto(OfficePhoto $officePhoto): static
    {
        if (!$this->officePhotos->contains($officePhoto)) {
            $this->officePhotos->add($officePhoto);
            $officePhoto->setOfficeId($this);
        }

        return $this;
    }

    public function removeOfficePhoto(OfficePhoto $officePhoto): static
    {
        if ($this->officePhotos->removeElement($officePhoto)) {
            // set the owning side to null (unless already changed)
            if ($officePhoto->getOfficeId() === $this) {
                $officePhoto->setOfficeId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TimeConfiguration>
     */
    public function getTimeConfigurations(): Collection
    {
        return $this->timeConfigurations;
    }

    public function addTimeConfiguration(TimeConfiguration $timeConfiguration): static
    {
        if (!$this->timeConfigurations->contains($timeConfiguration)) {
            $this->timeConfigurations->add($timeConfiguration);
            $timeConfiguration->setOfficeId($this);
        }

        return $this;
    }

    public function removeTimeConfiguration(TimeConfiguration $timeConfiguration): static
    {
        if ($this->timeConfigurations->removeElement($timeConfiguration)) {
            // set the owning side to null (unless already changed)
            if ($timeConfiguration->getOfficeId() === $this) {
                $timeConfiguration->setOfficeId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Profession>
     */
    public function getProfessions(): Collection
    {
        return $this->professions;
    }

    public function addProfession(Profession $profession): static
    {
        if (!$this->professions->contains($profession)) {
            $this->professions->add($profession);
            $profession->addOfficeId($this);
        }

        return $this;
    }

    public function removeProfession(Profession $profession): static
    {
        if ($this->professions->removeElement($profession)) {
            $profession->removeOfficeId($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Profession>
     */
    public function getProfessionId(): Collection
    {
        return $this->profession;
    }

    public function addProfessionId(Profession $professionId): static
    {
        if (!$this->profession->contains($professionId)) {
            $this->profession->add($professionId);
        }

        return $this;
    }

    public function removeProfessionId(Profession $professionId): static
    {
        $this->profession->removeElement($professionId);

        return $this;
    }

    /**
     * @return Collection<int, OfficeTypeOfService>
     */
    public function getOfficeTypeOfServices(): Collection
    {
        return $this->officeTypeOfServices;
    }

    public function addOfficeTypeOfService(OfficeTypeOfService $officeTypeOfService): static
    {
        if (!$this->officeTypeOfServices->contains($officeTypeOfService)) {
            $this->officeTypeOfServices->add($officeTypeOfService);
            $officeTypeOfService->addOfficeId($this);
        }

        return $this;
    }

    public function removeOfficeTypeOfService(OfficeTypeOfService $officeTypeOfService): static
    {
        if ($this->officeTypeOfServices->removeElement($officeTypeOfService)) {
            $officeTypeOfService->removeOfficeId($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Rdv>
     */
    public function getRdvs(): Collection
    {
        return $this->rdvs;
    }

    public function addRdv(Rdv $rdv): static
    {
        if (!$this->rdvs->contains($rdv)) {
            $this->rdvs->add($rdv);
            $rdv->setOfficeId($this);
        }

        return $this;
    }

    public function removeRdv(Rdv $rdv): static
    {
        if ($this->rdvs->removeElement($rdv)) {
            // set the owning side to null (unless already changed)
            if ($rdv->getOfficeId() === $this) {
                $rdv->setOfficeId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, OfficeClosure>
     */
    public function getOfficeClosures(): Collection
    {
        return $this->officeClosures;
    }

    public function addOfficeClosure(OfficeClosure $officeClosure): static
    {
        if (!$this->officeClosures->contains($officeClosure)) {
            $this->officeClosures->add($officeClosure);
            $officeClosure->setOfficeId($this);
        }

        return $this;
    }

    public function removeOfficeClosure(OfficeClosure $officeClosure): static
    {
        if ($this->officeClosures->removeElement($officeClosure)) {
            // set the owning side to null (unless already changed)
            if ($officeClosure->getOfficeId() === $this) {
                $officeClosure->setOfficeId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Review>
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): static
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews->add($review);
            $review->setOfficeId($this);
        }

        return $this;
    }

    public function removeReview(Review $review): static
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getOfficeId() === $this) {
                $review->setOfficeId(null);
            }
        }

        return $this;
    }


    public function getOfficeStreetName(): ?string
    {
    return $this->officeStreetName;
    }

    public function setOfficeStreetName(?string $officeStreetName): self
    {
    $this->officeStreetName = $officeStreetName;
    return $this;
    }


}