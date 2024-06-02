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
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 500)]
    private ?string $content = null;

    #[ORM\ManyToOne(inversedBy: 'faqContents')]
    #[ORM\JoinColumn(nullable: false)]
    private ?FaqCategory $section = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $content_update = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

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

    public function getContentUpdate(): ?\DateTimeInterface
    {
        return $this->content_update;
    }

    public function setContentUpdate(\DateTimeInterface $content_update): static
    {
        $this->content_update = $content_update;

        return $this;
    }
}
