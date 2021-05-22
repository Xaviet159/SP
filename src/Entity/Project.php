<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProjectRepository::class)
 */
class Project
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $contributor;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isValid = false;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $objectiveAmount;

    /**
     * @ORM\Column(type="date")
     */
    private $startAt;

    /**
     * @ORM\Column(type="date")
     */
    private $endAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $projectSuportedBy;

    /**
     * @ORM\Column(type="boolean")
     */
    private $proposalContributor = false;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $urlSocial;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $urlImage;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $phoneNumber;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="projects")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getContributor(): ?int
    {
        return $this->contributor;
    }

    public function setContributor(?int $contributor): self
    {
        $this->contributor = $contributor;

        return $this;
    }

    public function getIsValid(): ?bool
    {
        return $this->isValid;
    }

    public function setIsValid(bool $isValid): self
    {
        $this->isValid = $isValid;

        return $this;
    }

    public function getObjectiveAmount(): ?int
    {
        return $this->objectiveAmount;
    }

    public function setObjectiveAmount(?int $objectiveAmount): self
    {
        $this->objectiveAmount = $objectiveAmount;

        return $this;
    }

    public function getStartAt(): ?\DateTimeInterface
    {
        return $this->startAt;
    }

    public function setStartAt(\DateTimeInterface $startAt): self
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getEndAt(): ?\DateTimeInterface
    {
        return $this->endAt;
    }

    public function setEndAt(\DateTimeInterface $endAt): self
    {
        $this->endAt = $endAt;

        return $this;
    }

    public function getProjectSuportedBy(): ?string
    {
        return $this->projectSuportedBy;
    }

    public function setProjectSuportedBy(?string $projectSuportedBy): self
    {
        $this->projectSuportedBy = $projectSuportedBy;

        return $this;
    }

    public function getProposalContributor(): ?bool
    {
        return $this->proposalContributor;
    }

    public function setProposalContributor(bool $proposalContributor): self
    {
        $this->proposalContributor = $proposalContributor;

        return $this;
    }

    public function getUrlSocial(): ?string
    {
        return $this->urlSocial;
    }

    public function setUrlSocial(?string $urlSocial): self
    {
        $this->urlSocial = $urlSocial;

        return $this;
    }

    public function getUrlImage(): ?string
    {
        return $this->urlImage;
    }

    public function setUrlImage(?string $urlImage): self
    {
        $this->urlImage = $urlImage;

        return $this;
    }

    public function getPhoneNumber(): ?int
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?int $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
