<?php

namespace App\Entity;

use App\Repository\NewsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NewsRepository::class)]
class News
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 600)]
    private ?string $news_content = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $news_date = null;

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

    public function getNewsContent(): ?string
    {
        return $this->news_content;
    }

    public function setNewsContent(string $news_content): static
    {
        $this->news_content = $news_content;

        return $this;
    }

    public function getNewsDate(): ?\DateTimeInterface
    {
        return $this->news_date;
    }

    public function setNewsDate(\DateTimeInterface $news_date): static
    {
        $this->news_date = $news_date;

        return $this;
    }
}
