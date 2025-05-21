<?php

namespace App\Entity;

use App\Repository\CertificateOwnedRepository;

use App\Traits\TimestampableTrait; //pour createAt et updateAt auto

use Doctrine\ORM\Mapping as ORM;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: CertificateOwnedRepository::class)]
class CertificateOwned
{
    use TimestampableTrait;   //pour createAt et updateAt auto

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $certificateOwnedLink = null;

    #[ORM\ManyToOne(inversedBy: 'certificateOwneds')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Profession $profession = null;

    #[ORM\ManyToOne(inversedBy: 'certificateOwneds')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCertificateOwnedLink(): ?string
    {
        return $this->certificateOwnedLink;
    }

    public function setCertificateOwnedLink(string $certificateOwnedLink): static
    {
        $this->certificateOwnedLink = $certificateOwnedLink;

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
