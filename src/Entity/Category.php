<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Event", mappedBy="category")
     */
    private $evenement;

    public function __construct()
    {
        $this->events = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    // /**
    //  * @return Collection|Event[]
    //  */
    // public function getEvents(): Collection
    // {
    //     return $this->events;
    // }

    /**
     * @return Collection|Event[]
     */
    public function getevenements(): Collection
    {
        return $this->evenements;
    }

    public function addEvenement(Event $evenement): static
    {
        if (!$this->evenements->contains($evenement)) {
            $this->evenements->add($evenement);
            $evenement->setCategory($this);
        }

        return $this;
    }

    public function removeEvenement(Event $evenement): static
    {
        if ($this->evenements->removeElement($evenement)) {
            if ($evenement->getCategory() === $this) {
                $evenement->setCategory(null);
            }
        }

        return $this;
    }

}
