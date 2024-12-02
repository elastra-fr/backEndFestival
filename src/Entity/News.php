<?php

namespace App\Entity;

use App\Repository\NewsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;

#[ORM\Entity(repositoryClass: NewsRepository::class)]
class News
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column (name: "news_id", type: "integer")]
    private ?int $newsId = null;

    #[ORM\Column(length: 255)]
    private ?string $newsTitle = null;

    #[ORM\Column(length: 600)]
    private ?string $newsContent = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $newsDate = null;

    #[ORM\ManyToOne(inversedBy: 'news')]
    #[ORM\JoinColumn(name: 'news_category_id', referencedColumnName: 'news_category_id', nullable: false)]
    private ?NewsCategory $NewsCategory = null;

    public function getNewsId(): ?int
    {
        return $this->newsId;
    }

    public function getNewsTitle(): ?string
    {
        return $this->newsTitle;
    }

    public function setNewsTitle(string $newsTitle): static
    {
        $this->newsTitle = $newsTitle;

        return $this;
    }

    public function getNewsContent(): ?string
    {
        return $this->newsContent;
    }

    public function setNewsContent(string $newsContent): static
    {
        $this->newsContent = $newsContent;

        return $this;
    }

    public function getNewsDate(): ?\DateTimeInterface
    {
        return $this->newsDate;
    }

    public function setNewsDate(\DateTimeInterface $newsDate): static
    {
        $this->newsDate = $newsDate;

        return $this;
    }

    public function getNewsCategory(): ?NewsCategory
    {
        return $this->NewsCategory;
    }

    public function setNewsCategory(?NewsCategory $NewsCategory): static
    {
        $this->NewsCategory = $NewsCategory;

        return $this;
    }
}
