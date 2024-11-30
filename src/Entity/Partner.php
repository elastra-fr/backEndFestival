<?php

namespace App\Entity;

use App\Repository\PartnerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PartnerRepository::class)]
class Partner
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column (name: "partner_id", type: "integer")]
    private ?int $partnerId = null;

    #[ORM\Column(length: 100)]
    private ?string $partnerName = null;

    #[ORM\ManyToOne(inversedBy: 'partners')]
    #[ORM\JoinColumn(name: 'partner_category_id', referencedColumnName: 'partner_category_id', nullable: false)]
    private ?PartnerCategory $category = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $partnerLogo = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $partnerDescription = null;

    public function getPartnerId(): ?int
    {
        return $this->partnerId;
    }

    public function getPartnerName(): ?string
    {
        return $this->partnerName;
    }

    public function setPartnerName(string $partnerName): static
    {
        $this->partnerName = $partnerName;

        return $this;
    }

    public function getPartnerCategory(): ?PartnerCategory
    {
        return $this->category;
    }

    public function setPartnerCategory(?PartnerCategory $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getPartnerLogo(): ?string
    {
        return $this->partnerLogo;
    }

    public function setPartnerLogo(?string $partnerLogo): static
    {
        $this->partnerLogo = $partnerLogo;

        return $this;
    }

    public function getPartnerDescription(): ?string
    {
        return $this->partnerDescription;
    }

    public function setPartnerDescription(?string $partnerDescription): static
    {
        $this->partnerDescription = $partnerDescription;

        return $this;
    }
}
