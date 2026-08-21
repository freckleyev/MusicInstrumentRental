<?php

namespace App\Entity;

use App\Repository\InstrumentsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: InstrumentsRepository::class)]
class Instruments
{
    public function __construct()
    {
        $this->is_active = true;
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Please enter instrument name.')]
    #[Assert\Length(
        min: 3, 
        max: 255, 
        minMessage: 'Instrument name must be at least {{ limit }} characters long.', 
        maxMessage: 'Instrument name cannot exceed {{ limit }} characters.'
    )]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Please enter instrument condition.')]
    #[Assert\Length(
        min: 3, 
        max: 255, 
        minMessage: 'Instrument condition must be at least {{ limit }} characters long.', 
        maxMessage: 'Instrument condition cannot exceed {{ limit }} characters.'
    )]
    private ?string $instrument_condition = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'Please enter instrument description.')]
    #[Assert\Length(
        min: 3, 
        max: 2048, 
        minMessage: 'Instrument description must be at least {{ limit }} characters long.', 
        maxMessage: 'Instrument description cannot exceed {{ limit }} characters.'
    )]
    private ?string $description = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    #[Assert\NotBlank(message: 'Please enter daily rental price.')]
    #[Assert\Positive(message: 'Daily rental price must be a positive number.')]
    private ?string $daily_rental_price = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column]
    private ?bool $is_active = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: 'Please select a category.')]
    private ?Categories $category = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getInstrumentCondition(): ?string
    {
        return $this->instrument_condition;
    }

    public function setInstrumentCondition(string $instrument_condition): static
    {
        $this->instrument_condition = $instrument_condition;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDailyRentalPrice(): ?string
    {
        return $this->daily_rental_price;
    }

    public function setDailyRentalPrice(string $daily_rental_price): static
    {
        $this->daily_rental_price = $daily_rental_price;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->is_active;
    }

    public function setIsActive(bool $is_active): static
    {
        $this->is_active = $is_active;

        return $this;
    }

    public function getCategory(): ?Categories
    {
        return $this->category;
    }

    public function setCategory(?Categories $category): static
    {
        $this->category = $category;

        return $this;
    }
}
