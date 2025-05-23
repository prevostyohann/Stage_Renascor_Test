<?php

namespace App\Entity;

use App\Repository\UserRepository;

use App\Traits\TimestampableTrait;  //pour createAt et updateAt auto
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection; 

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;


#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{

    use TimestampableTrait;   //pour createAt et updateAt auto

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 30)]
    private ?string $username = null;

    #[ORM\Column(length: 30)]
    private ?string $lastName = null;

    #[ORM\Column(length: 30)]
    private ?string $firstName = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $streetNumber = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $streetName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $addressComplement = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column]
    private ?int $postalCode = null;

    #[ORM\Column(length: 30)]
    private ?string $city = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $country = null;

    #[ORM\Column]
    private ?float $latitude = null;

    #[ORM\Column]
    private ?float $longitude = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $birthDate = null;

    #[ORM\Column(length: 20)]
    private ?string $phoneNumber = null;

    /**
     * @var Collection<int, Office>
     */
    #[ORM\OneToMany(targetEntity: Office::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $offices;

    /**
     * @var Collection<int, CertificateOwned>
     */
    #[ORM\OneToMany(targetEntity: CertificateOwned::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $certificateOwneds;

    /**
     * @var Collection<int, DegreeOwned>
     */
    #[ORM\OneToMany(targetEntity: DegreeOwned::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $degreeOwneds;

    /**
     * @var Collection<int, Faq>
     */
    #[ORM\OneToMany(targetEntity: Faq::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $faqs;

    /**
     * @var Collection<int, Rdv>
     */
    #[ORM\OneToMany(targetEntity: Rdv::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $rdvs;

    /**
     * @var Collection<int, Review>
     */
    #[ORM\OneToMany(targetEntity: Review::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $reviews;

    public function __construct()
    {
        $this->offices = new ArrayCollection();
        $this->certificateOwneds = new ArrayCollection();
        $this->degreeOwneds = new ArrayCollection();
        $this->faqs = new ArrayCollection();
        $this->rdvs = new ArrayCollection();
        $this->reviews = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getStreetNumber(): ?string
    {
        return $this->streetNumber;
    }

    public function setStreetNumber(?string $streetNumber): static
    {
        $this->streetNumber = $streetNumber;

        return $this;
    }

    public function getStreetName(): ?string
    {
    return $this->streetName;
    }

    public function setStreetName(?string $streetName): self
    {
    $this->streetName = $streetName;
    return $this;
    }

    public function getAddressComplement(): ?string
    {
    return $this->addressComplement;
    }

    public function setAddressComplement(?string $addressComplement): static
    {
    $this->addressComplement = $addressComplement;

    return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getPostalCode(): ?int
    {
        return $this->postalCode;
    }

    public function setPostalCode(int $postalCode): static
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): static
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): static
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTimeInterface $birthDate): static
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): static
    {
        $this->phoneNumber = $phoneNumber;

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
            $office->setUserId($this);
        }

        return $this;
    }

    public function removeOffice(Office $office): static
    {
        if ($this->offices->removeElement($office)) {
            // set the owning side to null (unless already changed)
            if ($office->getUserId() === $this) {
                $office->setUserId(null);
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
            $certificateOwned->setUserId($this);
        }

        return $this;
    }

    public function removeCertificateOwned(CertificateOwned $certificateOwned): static
    {
        if ($this->certificateOwneds->removeElement($certificateOwned)) {
            // set the owning side to null (unless already changed)
            if ($certificateOwned->getUserId() === $this) {
                $certificateOwned->setUserId(null);
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
            $degreeOwned->setUserId($this);
        }

        return $this;
    }

    public function removeDegreeOwned(DegreeOwned $degreeOwned): static
    {
        if ($this->degreeOwneds->removeElement($degreeOwned)) {
            // set the owning side to null (unless already changed)
            if ($degreeOwned->getUserId() === $this) {
                $degreeOwned->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Faq>
     */
    public function getFaqs(): Collection
    {
        return $this->faqs;
    }

    public function addFaq(Faq $faq): static
    {
        if (!$this->faqs->contains($faq)) {
            $this->faqs->add($faq);
            $faq->setUserId($this);
        }

        return $this;
    }

    public function removeFaq(Faq $faq): static
    {
        if ($this->faqs->removeElement($faq)) {
            // set the owning side to null (unless already changed)
            if ($faq->getUserId() === $this) {
                $faq->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Rdv>
     */
    public function getRdvs(): Collection
    {
        return $this->rdvs;
    }

    public function addRdv(Rdv $rdv): static
    {
        if (!$this->rdvs->contains($rdv)) {
            $this->rdvs->add($rdv);
            $rdv->setUserId($this);
        }

        return $this;
    }

    public function removeRdv(Rdv $rdv): static
    {
        if ($this->rdvs->removeElement($rdv)) {
            // set the owning side to null (unless already changed)
            if ($rdv->getUserId() === $this) {
                $rdv->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Review>
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): static
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews->add($review);
            $review->setUserId($this);
        }

        return $this;
    }

    public function removeReview(Review $review): static
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getUserId() === $this) {
                $review->setUserId(null);
            }
        }

        return $this;
    }

}
