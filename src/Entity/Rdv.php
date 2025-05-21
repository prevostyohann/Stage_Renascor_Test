<?php

namespace App\Entity;

use App\Enum\statusRdvEnum;
use App\Repository\RdvRepository;

use App\Traits\TimestampableTrait; //pour createAt et updateAt auto

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: RdvRepository::class)]
class Rdv
{
    use TimestampableTrait;   //pour createAt et updateAt auto

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $hourOfRdv = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $endOfRdv = null;

    #[ORM\Column(enumType: statusRdvEnum::class)]
    private ?statusRdvEnum $status = null;

    #[ORM\ManyToOne(inversedBy: 'rdvs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'rdvs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Office $office = null;

    #[ORM\ManyToOne(inversedBy: 'rdvs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?OfficeTypeOfService $officeTypeOfService = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getHourOfRdv(): ?\DateTimeInterface
    {
        return $this->hourOfRdv;
    }

    public function setHourOfRdv(\DateTimeInterface $hourOfRdv): static
    {
        $this->hourOfRdv = $hourOfRdv;

        return $this;
    }

    public function getEndOfRdv(): ?\DateTimeInterface
    {
        return $this->endOfRdv;
    }

    public function setEndOfRdv(\DateTimeInterface $endOfRdv): static
    {
        $this->endOfRdv = $endOfRdv;

        return $this;
    }

    public function getStatus(): ?statusRdvEnum
    {
        return $this->status;
    }

    public function setStatus(statusRdvEnum $status): static
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;
        return $this;
    }

    public function getOfficeId(): ?Office
    {
        return $this->office;
    }

    public function setOfficeId(?Office $office): static
    {
        $this->office = $office;

        return $this;
    }

    public function getOffice(): ?Office
    {
        return $this->office;
    }

    public function setOffice(?Office $office): static
    {
        $this->office = $office;

        return $this;
    }

    public function getOfficeTypeOfServiceId(): ?OfficeTypeOfService
    {
        return $this->officeTypeOfService;
    }

    public function setOfficeTypeOfServiceId(?OfficeTypeOfService $officeTypeOfService): static
    {
        $this->officeTypeOfService = $officeTypeOfService;

        return $this;
    }
}