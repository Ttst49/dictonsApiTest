<?php

namespace App\Entity;

use App\Repository\AuthorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: AuthorRepository::class)]
#[UniqueEntity("name")]
class Author
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups("dicton")]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Dicton::class,cascade: ["persist"])]
    private Collection $dictons;

    public function __construct()
    {
        $this->dictons = new ArrayCollection();
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

    /**
     * @return Collection<int, Dicton>
     */
    public function getDictons(): Collection
    {
        return $this->dictons;
    }

    public function addDicton(Dicton $dicton): static
    {
        if (!$this->dictons->contains($dicton)) {
            $this->dictons->add($dicton);
            $dicton->setAuthor($this);
        }

        return $this;
    }

    public function removeDicton(Dicton $dicton): static
    {
        if ($this->dictons->removeElement($dicton)) {
            // set the owning side to null (unless already changed)
            if ($dicton->getAuthor() === $this) {
                $dicton->setAuthor(null);
            }
        }

        return $this;
    }
}
