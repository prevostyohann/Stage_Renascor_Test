<?php

namespace App\Entity;

use App\Repository\ProfessionRepository;

use App\Traits\TimestampableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection; //pour createAt et updateAt auto

use Doctrine\ORM\Mapping as ORM;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: ProfessionRepository::class)]
class Profession
{
    use TimestampableTrait;   //pour createAt et updateAt auto

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 60)]
    private ?string $name = null;

   

    /**
     * @var Collection<int, Office>
     */
    #[ORM\ManyToMany(targetEntity: Office::class, mappedBy: 'profession')]
    private Collection $offices;

    /**
     * @var Collection<int, Speciality>
     */
    #[ORM\OneToMany(targetEntity: Speciality::class, mappedBy: 'profession', orphanRemoval: true)]
    private Collection $specialities;

    /**
     * @var Collection<int, CertificateOwned>
     */
    #[ORM\OneToMany(targetEntity: CertificateOwned::class, mappedBy: 'profession', orphanRemoval: true)]
    private Collection $certificateOwneds;

    /**
     * @var Collection<int, DegreeOwned>
     */
    #[ORM\OneToMany(targetEntity: DegreeOwned::class, mappedBy: 'profession', orphanRemoval: true)]
    private Collection $degreeOwneds;

    public function __construct()
    {
        $this->offices = new ArrayCollection();
        $this->specialities = new ArrayCollection();
        $this->certificateOwneds = new ArrayCollection();
        $this->degreeOwneds = new ArrayCollection();
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

    

    /**
     * @return Collection<int, Office>
     */
    public function getOffices(): Collection
    {
        return $this->offices;
    }

    public function addOffice(Office $office): static
{
    if (!$this->offices->contains($office)) {
        $this->offices->add($office);
    }

    return $this;
}

    public function removeOffice(Office $office): static
    {
        if ($this->offices->removeElement($office)) {
            $office->removeProfession($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Speciality>
     */
    public function getSpecialities(): Collection
    {
        return $this->specialities;
    }

    public function addSpeciality(Speciality $speciality): static
    {
        if (!$this->specialities->contains($speciality)) {
            $this->specialities->add($speciality);
            $speciality->setProfessionId($this);
        }

        return $this;
    }

    public function removeSpeciality(Speciality $speciality): static
    {
        if ($this->specialities->removeElement($speciality)) {
            // set the owning side to null (unless already changed)
            if ($speciality->getProfessionId() === $this) {
                $speciality->setProfessionId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CertificateOwned>
     */
    public function getCertificateOwneds(): Collection
    {
        return $this->certificateOwneds;
    }

    public function addCertificateOwned(CertificateOwned $certificateOwned): static
    {
        if (!$this->certificateOwneds->contains($certificateOwned)) {
            $this->certificateOwneds->add($certificateOwned);
            $certificateOwned->setProfessionId($this);
        }

        return $this;
    }

    public function removeCertificateOwned(CertificateOwned $certificateOwned): static
    {
        if ($this->certificateOwneds->removeElement($certificateOwned)) {
            // set the owning side to null (unless already changed)
            if ($certificateOwned->getProfessionId() === $this) {
                $certificateOwned->setProfessionId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, DegreeOwned>
     */
    public function getDegreeOwneds(): Collection
    {
        return $this->degreeOwneds;
    }

    public function addDegreeOwned(DegreeOwned $degreeOwned): static
    {
        if (!$this->degreeOwneds->contains($degreeOwned)) {
            $this->degreeOwneds->add($degreeOwned);
            $degreeOwned->setProfessionId($this);
        }

        return $this;
    }

    public function removeDegreeOwned(DegreeOwned $degreeOwned): static
    {
        if ($this->degreeOwneds->removeElement($degreeOwned)) {
            // set the owning side to null (unless already changed)
            if ($degreeOwned->getProfessionId() === $this) {
                $degreeOwned->setProfessionId(null);
            }
        }

        return $this;
    }
}
