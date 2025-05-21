<?php

namespace App\Entity;

use App\Repository\TypeOfServiceRepository;

use App\Traits\TimestampableTrait;   //pour createAt et updateAt auto
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection; 

use Doctrine\ORM\Mapping as ORM;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: TypeOfServiceRepository::class)]
class TypeOfService
{
    use TimestampableTrait;   //pour createAt et updateAt auto

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 60)]
    private ?string $name = null;

    #[ORM\Column]
    private ?bool $status = null;

    #[ORM\ManyToOne(inversedBy: 'typeOfServices')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Speciality $speciality = null;

    /**
     * @var Collection<int, OfficeTypeOfService>
     */
    #[ORM\ManyToMany(targetEntity: OfficeTypeOfService::class, mappedBy: 'typeOfService')]
    private Collection $officeTypeOfServices;

    public function __construct()
    {
        $this->officeTypeOfServices = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getSpecialityId(): ?Speciality
    {
        return $this->speciality;
    }

    public function setSpecialityId(?Speciality $speciality): static
    {
        $this->speciality = $speciality;

        return $this;
    }

    public function getSpeciality(): ?Speciality
    {
        return $this->speciality;
    }

    public function setSpeciality(?Speciality $speciality): static
    {
        $this->speciality = $speciality;

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
            $officeTypeOfService->addTypeOfServiceId($this);
        }

        return $this;
    }

    public function removeOfficeTypeOfService(OfficeTypeOfService $officeTypeOfService): static
    {
        if ($this->officeTypeOfServices->removeElement($officeTypeOfService)) {
            $officeTypeOfService->removeTypeOfServiceId($this);
        }

        return $this;
    }

}
