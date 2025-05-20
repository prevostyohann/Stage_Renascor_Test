<?php

namespace App\Entity;

use App\Enum\notesEnum;
use App\Repository\ReviewRepository;

use App\Traits\TimestampableTrait; //pour createAt et updateAt auto

use Doctrine\ORM\Mapping as ORM;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: ReviewRepository::class)]
class Review
{
    use TimestampableTrait;   //pour createAt et updateAt auto

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(enumType: notesEnum::class)]
    private ?notesEnum $note = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $comment = null;

    #[ORM\ManyToOne(inversedBy: 'reviews')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'reviews')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Office $office = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?notesEnum
    {
        return $this->note;
    }

    public function setNote(notesEnum $note): static
    {
        $this->note = $note;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): static
    {
        $this->comment = $comment;

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
