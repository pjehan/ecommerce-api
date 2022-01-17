<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    normalizationContext: ['groups' => ['product:read']]
)]
#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[Groups('product:read')]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[Groups(['product:read', 'category:read'])]
    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[Groups('product:read')]
    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[Groups(['product:read', 'category:read'])]
    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private float $price;

    #[Groups('product:read')]
    #[ORM\Column(type: 'integer')]
    private int $quantity;

    #[ApiProperty(iri: 'https://schema.org/image')]
    #[Groups(['product:read', 'category:read'])]
    #[ORM\ManyToOne(targetEntity: MediaObject::class, cascade: ['persist'])]
    private ?MediaObject $image = null;

    #[Groups('product:read')]
    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: BasketProduct::class, orphanRemoval: true)]
    private Collection $basketProducts;

    #[Pure]
    public function __construct()
    {
        $this->basketProducts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
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

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getImage(): ?MediaObject
    {
        return $this->image;
    }

    public function setImage(?MediaObject $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|BasketProduct[]
     */
    public function getBasketProducts(): Collection
    {
        return $this->basketProducts;
    }

    public function addBasketProduct(BasketProduct $basketProduct): self
    {
        if (!$this->basketProducts->contains($basketProduct)) {
            $this->basketProducts[] = $basketProduct;
            $basketProduct->setProduct($this);
        }

        return $this;
    }

    public function removeBasketProduct(BasketProduct $basketProduct): self
    {
        if ($this->basketProducts->removeElement($basketProduct)) {
            // set the owning side to null (unless already changed)
            if ($basketProduct->getProduct() === $this) {
                $basketProduct->setProduct(null);
            }
        }

        return $this;
    }
}
