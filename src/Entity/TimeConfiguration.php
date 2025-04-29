<?php

namespace App\Entity;

use App\Enum\daysEnum;
use App\Repository\TimeConfigurationRepository;

use App\Traits\TimestampableTrait;  //pour createAt et updateAt auto

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TimeConfigurationRepository::class)]
class TimeConfiguration
{
    use TimestampableTrait;   //pour createAt et updateAt auto

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(enumType: daysEnum::class)]
    private ?daysEnum $day = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $openTime = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $closeTime = null;

    #[ORM\Column(nullable: true)]
    private ?\DateInterval $rdvInterval = null;

    #[ORM\ManyToOne(inversedBy: 'timeConfigurations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Office $office = null;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDay(): ?daysEnum
    {
        return $this->day;
    }

    public function setDay(daysEnum $day): static
    {
        $this->day = $day;

        return $this;
    }

    public function getOpenTime(): ?\DateTimeInterface
    {
        return $this->openTime;
    }

    public function setOpenTime(\DateTimeInterface $openTime): static
    {
        $this->openTime = $openTime;

        return $this;
    }

    public function getCloseTime(): ?\DateTimeInterface
    {
        return $this->closeTime;
    }

    public function setCloseTime(\DateTimeInterface $closeTime): static
    {
        $this->closeTime = $closeTime;

        return $this;
    }

    public function getRdvInterval(): ?\DateInterval
    {
        return $this->rdvInterval;
    }

    public function setRdvInterval(?\DateInterval $rdvInterval): static
    {
        $this->rdvInterval = $rdvInterval;

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

}
