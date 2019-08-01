<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductsRepository")
 */
class Products
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProductSkus", mappedBy="products")
     */
    private $productSkus;

    /**
     * @ORM\Column(type="string", length=120, unique=true)
     */
    private $link;

    /**
     * @ORM\Column(type="string", length=120, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="json_array", nullable=true)
     */
    private $images;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Categories", inversedBy="products")
     */
    private $category;

    public function __construct()
    {
        $this->productSkus = new ArrayCollection();
        $this->category = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|ProductSkus[]
     */
    public function getProductSkus(): Collection
    {
        return $this->productSkus;
    }

    public function addProductSkus(ProductSkus $productSkus): self
    {
        if (!$this->productSkus->contains($productSkus)) {
            $this->productSkus[] = $productSkus;
            $productSkus->setProducts($this);
        }

        return $this;
    }

    public function removeProductSkus(ProductSkus $productSkus): self
    {
        if ($this->productSkus->contains($productSkus)) {
            $this->productSkus->removeElement($productSkus);
            // set the owning side to null (unless already changed)
            if ($productSkus->getProducts() === $this) {
                $productSkus->setProducts(null);
            }
        }

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImages()
    {
        return $this->images;
    }

    public function setImages($images): self
    {
        $this->images = $images;

        return $this;
    }

    /**
     * @return Collection|Categories[]
     */
    public function getCategory(): Collection
    {
        return $this->category;
    }

    public function addCategory(Categories $category): self
    {
        if (!$this->category->contains($category)) {
            $this->category[] = $category;
        }

        return $this;
    }

    public function removeCategory(Categories $category): self
    {
        if ($this->category->contains($category)) {
            $this->category->removeElement($category);
        }

        return $this;
    }

}
