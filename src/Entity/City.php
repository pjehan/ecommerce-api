<?php

namespace App\Entity;

use App\Repository\CityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

#[ORM\Entity(repositoryClass: CityRepository::class)]
class City
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(length: 255)]
    private string $zipCode;

    #[ORM\OneToMany(mappedBy: 'city', targetEntity: User::class)]
    private Collection $users;

    #[ORM\Column(nullable: true)]
    private ?int $population1999 = null;

    #[ORM\Column(nullable: true)]
    private ?int $population2010 = null;

    #[ORM\Column(nullable: true)]
    private ?int $population2012 = null;

    #[Pure]
    public function __construct()
    {
        $this->users = new ArrayCollection();
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

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(string $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setCity($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getCity() === $this) {
                $user->setCity(null);
            }
        }

        return $this;
    }

    public function getPopulation1999(): ?int
    {
        return $this->population1999;
    }

    public function setPopulation1999(?int $population1999): self
    {
        $this->population1999 = $population1999;

        return $this;
    }

    public function getPopulation2010(): ?int
    {
        return $this->population2010;
    }

    public function setPopulation2010(?int $population2010): self
    {
        $this->population2010 = $population2010;

        return $this;
    }

    public function getPopulation2012(): ?int
    {
        return $this->population2012;
    }

    public function setPopulation2012(?int $population2012): self
    {
        $this->population2012 = $population2012;

        return $this;
    }
}
