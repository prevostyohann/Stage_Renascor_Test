<?php

namespace App\Entity;

use App\Repository\SpecialityRepository;

use App\Traits\TimestampableTrait;  //pour createAt et updateAt auto
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection; 

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SpecialityRepository::class)]
class Speciality
{
    use TimestampableTrait;   //pour createAt et updateAt auto

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 60)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'specialities')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Profession $profession = null;

    /**
     * @var Collection<int, TypeOfService>
     */
    #[ORM\OneToMany(targetEntity: TypeOfService::class, mappedBy: 'speciality', orphanRemoval: true)]
    private Collection $typeOfServices;

    public function __construct()
    {
        $this->typeOfServices = new ArrayCollection();
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

    public function getProfessionId(): ?Profession
    {
        return $this->profession;
    }

    public function setProfessionId(?Profession $profession): static
    {
        $this->profession = $profession;

        return $this;
    }

    /**
     * @return Collection<int, TypeOfService>
     */
    public function getTypeOfServices(): Collection
    {
        return $this->typeOfServices;
    }

    public function addTypeOfService(TypeOfService $typeOfService): static
    {
        if (!$this->typeOfServices->contains($typeOfService)) {
            $this->typeOfServices->add($typeOfService);
            $typeOfService->setSpecialityId($this);
        }

        return $this;
    }

    public function removeTypeOfService(TypeOfService $typeOfService): static
    {
        if ($this->typeOfServices->removeElement($typeOfService)) {
            // set the owning side to null (unless already changed)
            if ($typeOfService->getSpecialityId() === $this) {
                $typeOfService->setSpecialityId(null);
            }
        }

        return $this;
    }
}
