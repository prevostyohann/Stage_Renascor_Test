<?php

namespace App\Entity;

use App\Repository\DegreeOwnedRepository;

use App\Traits\TimestampableTrait; //pour createAt et updateAt auto

use Doctrine\ORM\Mapping as ORM;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: DegreeOwnedRepository::class)]
class DegreeOwned
{
    use TimestampableTrait;   //pour createAt et updateAt auto

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $degreeOwnedLink = null;

    #[ORM\ManyToOne(inversedBy: 'degreeOwneds')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Profession $profession = null;

    #[ORM\ManyToOne(inversedBy: 'degreeOwneds')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDegreeOwnedLink(): ?string
    {
        return $this->degreeOwnedLink;
    }

    public function setDegreeOwnedLink(string $degreeOwnedLink): static
    {
        $this->degreeOwnedLink = $degreeOwnedLink;

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

    public function getUserId(): ?User
    {
        return $this->user;
    }

    public function setUserId(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
