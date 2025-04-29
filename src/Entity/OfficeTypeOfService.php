<?php

namespace App\Entity;

use App\Repository\OfficeTypeOfServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use App\Traits\TimestampableTrait; //pour createAt et updateAt auto


#[ORM\Entity(repositoryClass: OfficeTypeOfServiceRepository::class)]
class OfficeTypeOfService
{
    use TimestampableTrait;   //pour createAt et updateAt auto

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column(length: 15)]
    private ?string $currency = null;

    #[ORM\Column]
    private ?\DateInterval $duration = null;

    /**
     * @var Collection<int, Office>
     */
    #[ORM\ManyToMany(targetEntity: Office::class, inversedBy: 'officeTypeOfServices')]
    private Collection $office;

    /**
     * @var Collection<int, TypeOfService>
     */
    #[ORM\ManyToMany(targetEntity: TypeOfService::class, inversedBy: 'officeTypeOfServices')]
    private Collection $typeOfService;

    /**
     * @var Collection<int, Rdv>
     */
    #[ORM\OneToMany(targetEntity: Rdv::class, mappedBy: 'officeTypeOfService', orphanRemoval: true)]
    private Collection $rdvs;

    public function __construct()
    {
        $this->office = new ArrayCollection();
        $this->typeOfService = new ArrayCollection();
        $this->rdvs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): static
    {
        $this->currency = $currency;

        return $this;
    }

    public function getDuration(): ?\DateInterval
    {
        return $this->duration;
    }

    public function setDuration(\DateInterval $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * @return Collection<int, Office>
     */
    public function getOfficeId(): Collection
    {
        return $this->office;
    }

    public function addOfficeId(Office $officeId): static
    {
        if (!$this->office->contains($officeId)) {
            $this->office->add($officeId);
        }

        return $this;
    }

    public function removeOfficeId(Office $officeId): static
    {
        $this->office->removeElement($officeId);

        return $this;
    }

    /**
     * @return Collection<int, TypeOfService>
     */
    public function getTypeOfServiceId(): Collection
    {
        return $this->typeOfService;
    }

    public function addTypeOfServiceId(TypeOfService $typeOfServiceId): static
    {
        if (!$this->typeOfService->contains($typeOfServiceId)) {
            $this->typeOfService->add($typeOfServiceId);
        }

        return $this;
    }

    public function removeTypeOfServiceId(TypeOfService $typeOfServiceId): static
    {
        $this->typeOfService->removeElement($typeOfServiceId);

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
            $rdv->setOfficeTypeOfServiceId($this);
        }

        return $this;
    }

    public function removeRdv(Rdv $rdv): static
    {
        if ($this->rdvs->removeElement($rdv)) {
            // set the owning side to null (unless already changed)
            if ($rdv->getOfficeTypeOfServiceId() === $this) {
                $rdv->setOfficeTypeOfServiceId(null);
            }
        }

        return $this;
    }
}
