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
    private ?int $newsCategoryId = null;

    #[ORM\Column(length: 100)]
    private ?string $newsCategoryName = null;

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
        return $this->newsCategoryId;
    }

    public function getNewsCategoryName(): ?string
    {
        return $this->newsCategoryName;
    }

    public function setNewsCategoryName(string $newsCategoryName): static
    {
        $this->newsCategoryName = $newsCategoryName;

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
