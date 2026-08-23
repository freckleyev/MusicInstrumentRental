<?php

namespace App\Entity;

use App\Enum\RentalRequestStatus;
use App\Repository\RentalRequestsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RentalRequestsRepository::class)]
class RentalRequests
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'instrument')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Instruments $instrument = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(message: 'Please select a start date.')]
    #[Assert\GreaterThanOrEqual('today', message: 'Start date cannot be in the past.')]
    private ?\DateTime $startDate = null;

    #[Assert\NotBlank(message: 'Please select a start date.')]
    #[Assert\GreaterThan(propertyPath: 'startDate', message: 'End date must after the start date. Minimum rental period is 1 day.')]
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $endDate = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'Please provide a rental purpose.')]
    #[Assert\Length(
        min: 10,
        max: 500,
        minMessage: 'Purpose must be at least 10 characters long.'
    )]
    private ?string $purpose = null;

    #[ORM\Column(enumType: RentalRequestStatus::class)]
    private ?RentalRequestStatus $status = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'reviewed_by', referencedColumnName: 'id', nullable: true)]
    private ?User $reviewedBy = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $rejectionReason = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getInstrument(): ?Instruments
    {
        return $this->instrument;
    }

    public function setInstrument(?Instruments $instrument): static
    {
        $this->instrument = $instrument;

        return $this;
    }

    public function getStartDate(): ?\DateTime
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTime $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTime
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTime $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getPurpose(): ?string
    {
        return $this->purpose;
    }

    public function setPurpose(string $purpose): static
    {
        $this->purpose = $purpose;

        return $this;
    }

    public function getStatus(): ?RentalRequestStatus
    {
        return $this->status;
    }

    public function setStatus(RentalRequestStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getReviewedBy(): ?User
    {
        return $this->reviewedBy;
    }

    public function setReviewedBy(?User $reviewedBy): self
    {
        $this->reviewedBy = $reviewedBy;

        return $this;
    }

    public function getRejectionReason(): ?string
    {
        return $this->rejectionReason;
    }

    public function setRejectionReason(?string $rejectionReason): static
    {
        $this->rejectionReason = $rejectionReason;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    
    // Calculates total days between start and end date.
    public function getDurationInDays(): int
    {
        if (!$this->startDate || !$this->endDate) {
            return 0;
        }
        return (int) $this->startDate->diff($this->endDate)->days;
    }

    // Calculates the total rental price.
    public function getTotalPrice(): float
    {
        if (!$this->instrument) {
            return 0.0;
        }

        return $this->getDurationInDays() * $this->instrument->getDailyRentalPrice();
    }
}
