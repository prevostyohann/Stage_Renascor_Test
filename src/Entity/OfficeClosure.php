<?php

namespace App\Entity;

use App\Repository\OfficeClosureRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use App\Traits\TimestampableTrait; //pour createAt et updateAt auto


#[ORM\Entity(repositoryClass: OfficeClosureRepository::class)]
class OfficeClosure
{
    use TimestampableTrait;   //pour createAt et updateAt auto

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $start = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $end = null;

    #[ORM\ManyToOne(inversedBy: 'officeClosures')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Office $office = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStart(): ?\DateTimeInterface
    {
        return $this->start;
    }

    public function setStart(\DateTimeInterface $start): static
    {
        $this->start = $start;

        return $this;
    }

    public function getEnd(): ?\DateTimeInterface
    {
        return $this->end;
    }

    public function setEnd(\DateTimeInterface $end): static
    {
        $this->end = $end;

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
