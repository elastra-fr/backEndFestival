<?php

namespace App\Entity;

use App\Repository\FaqContentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FaqContentRepository::class)]
class FaqContent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $faqContentId = null;

    #[ORM\Column(length: 100)]
    private ?string $faqContentTitle = null;

    #[ORM\Column(length: 500)]
    private ?string $faqContentDetails = null;

    #[ORM\ManyToOne(inversedBy: 'faqContents')]
   #[ORM\JoinColumn(name: 'faq_category_id', referencedColumnName: 'faq_category_id', nullable: false)]
    private ?FaqCategory $section = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $faqContentUpdate = null;

    public function getFaqContentId(): ?int
    {
        return $this->faqContentId;
    }

    public function getFaqContentTitle(): ?string
    {
        return $this->faqContentTitle;
    }

    public function setFaqContentTitle(string $faqContentTitle): static
    {
        $this->faqContentTitle = $faqContentTitle;

        return $this;
    }

    public function getFaqContentDetails(): ?string
    {
        return $this->faqContentDetails;
    }

    public function setFaqContentDetails(string $faqContentDetails): static
    {
        $this->faqContentDetails = $faqContentDetails;

        return $this;
    }

    public function getSection(): ?FaqCategory
    {
        return $this->section;
    }

    public function setSection(?FaqCategory $section): static
    {
        $this->section = $section;

        return $this;
    }

    public function getFaqContentUpdate(): ?\DateTimeInterface
    {
        return $this->faqContentUpdate;
    }

    public function setFaqContentUpdate(\DateTimeInterface $faqContentUpdate): static
    {
        $this->faqContentUpdate = $faqContentUpdate;

        return $this;
    }
}
