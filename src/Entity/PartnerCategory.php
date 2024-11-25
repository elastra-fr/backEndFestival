<?php

namespace App\Entity;

use App\Repository\PartnerCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PartnerCategoryRepository::class)]
class PartnerCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column (name: "partner_category_id", type: "integer")]
    private ?int $partnerCategoryId = null;

    #[ORM\Column(length: 255)]
    private ?string $partnerCategory = null;

    /**
     * @var Collection<int, Partner>
     */
    #[ORM\OneToMany(targetEntity: Partner::class, mappedBy: 'category')]
    private Collection $partners;

    public function __construct()
    {
        $this->partners = new ArrayCollection();
    }

    public function getPartnerCategoryId(): ?int
    {
        return $this->partnerCategoryId;
    }

    public function getPartnerCategory(): ?string
    {
        return $this->partnerCategory;
    }

    public function setPartnerCategory(string $partnerCategory): static
    {
        $this->partnerCategory = $partnerCategory;

        return $this;
    }

    /**
     * @return Collection<int, Partner>
     */
    public function getPartners(): Collection
    {
        return $this->partners;
    }

    public function addPartner(Partner $partner): static
    {
        if (!$this->partners->contains($partner)) {
            $this->partners->add($partner);
            $partner->setPartnerCategory($this);
        }

        return $this;
    }

    public function removePartner(Partner $partner): static
    {
        if ($this->partners->removeElement($partner)) {
            // set the owning side to null (unless already changed)
            if ($partner->getPartnerCategory() === $this) {
                $partner->setPartnerCategory(null);
            }
        }

        return $this;
    }
}
