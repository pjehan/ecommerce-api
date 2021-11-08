<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
#[ApiResource(
    normalizationContext: ['groups' => ['product:read']]
)]
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups('product:read')]
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['product:read', 'category:read'])]
    private string $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    #[Groups('product:read')]
    private ?string $description;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    #[Groups(['product:read', 'category:read'])]
    private float $price;

    /**
     * @ORM\Column(type="integer")
     */
    #[Groups('product:read')]
    private int $quantity;

    /**
     * @ORM\ManyToOne(targetEntity=MediaObject::class, cascade={"persist"})
     */
    #[ApiProperty(iri: 'https://schema.org/image')]
    #[Groups(['product:read', 'category:read'])]
    private ?MediaObject $image = null;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    #[Groups('product:read')]
    private ?Category $category;

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
}
