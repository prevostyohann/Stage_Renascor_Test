<?php

namespace App\Entity;

use App\Repository\OfficePhotoRepository;

use App\Traits\TimestampableTrait; //pour createAt et updateAt auto

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OfficePhotoRepository::class)]
class OfficePhoto
{
    use TimestampableTrait;   //pour createAt et updateAt auto

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $OfficePhotoLink = null;

    #[ORM\ManyToOne(inversedBy: 'officePhotos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Office $office = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOfficePhotoLink(): ?string
    {
        return $this->OfficePhotoLink;
    }

    public function setOfficePhotoLink(string $OfficePhotoLink): static
    {
        $this->OfficePhotoLink = $OfficePhotoLink;

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
