<?php

namespace App\Entity;

use App\Repository\NewsCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NewsCategoryRepository::class)]
class NewsCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column (name: "news_category_id", type: "integer")]
    private ?int $new_category_id = null;

    #[ORM\Column(length: 100)]
    private ?string $news_category_name = null;

    /**
     * @var Collection<int, News>
     */
    #[ORM\OneToMany(targetEntity: News::class, mappedBy: 'NewsCategory')]
    private Collection $news;

    public function __construct()
    {
        $this->news = new ArrayCollection();
    }

    public function getNewsCategoryId(): ?int
    {
        return $this->new_category_id;
    }

    public function getNewsCategoryName(): ?string
    {
        return $this->news_category_name;
    }

    public function setNewsCategoryName(string $news_category_name): static
    {
        $this->news_category_name = $news_category_name;

        return $this;
    }

    /**
     * @return Collection<int, News>
     */
    public function getNews(): Collection
    {
        return $this->news;
    }

    public function addNews(News $news): static
    {
        if (!$this->news->contains($news)) {
            $this->news->add($news);
            $news->setNewsCategory($this);
        }

        return $this;
    }

    public function removeNews(News $news): static
    {
        if ($this->news->removeElement($news)) {
            // set the owning side to null (unless already changed)
            if ($news->getNewsCategory() === $this) {
                $news->setNewsCategory(null);
            }
        }

        return $this;
    }
}
