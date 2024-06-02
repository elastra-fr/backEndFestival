<?php

namespace App\Entity;

use App\Repository\FaqCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FaqCategoryRepository::class)]
class FaqCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $category = null;

    /**
     * @var Collection<int, FaqContent>
     */
    #[ORM\OneToMany(targetEntity: FaqContent::class, mappedBy: 'section')]
    private Collection $faqContents;

    public function __construct()
    {
        $this->faqContents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): static
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, FaqContent>
     */
    public function getFaqContents(): Collection
    {
        return $this->faqContents;
    }

    public function addFaqContent(FaqContent $faqContent): static
    {
        if (!$this->faqContents->contains($faqContent)) {
            $this->faqContents->add($faqContent);
            $faqContent->setSection($this);
        }

        return $this;
    }

    public function removeFaqContent(FaqContent $faqContent): static
    {
        if ($this->faqContents->removeElement($faqContent)) {
            // set the owning side to null (unless already changed)
            if ($faqContent->getSection() === $this) {
                $faqContent->setSection(null);
            }
        }

        return $this;
    }
}
