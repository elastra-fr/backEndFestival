<?php

namespace App\Entity;

use App\Repository\PartnerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PartnerRepository::class)]
class Partner
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'partners')]
    #[ORM\JoinColumn(nullable: false)]
    private ?PartnerCategory $category = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $url_logo = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

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

    public function getCategory(): ?PartnerCategory
    {
        return $this->category;
    }

    public function setCategory(?PartnerCategory $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getUrlLogo(): ?string
    {
        return $this->url_logo;
    }

    public function setUrlLogo(?string $url_logo): static
    {
        $this->url_logo = $url_logo;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }
}
