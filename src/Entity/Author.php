<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AuthorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: AuthorRepository::class)]
#[ORM\Table(name:'authors')]
class Author
{
    public const FIRST_NAME_COLUMN = "first_name";
    public const LAST_NAME_COLUMN = "last_name";

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $firstName;

    #[ORM\Column(type: 'string', length: 255)]
    private $lastName;

    #[ORM\ManyToMany(targetEntity: Book::class)]
    private $book;

    public function __construct()
    {
        $this->book = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return Collection|BookAuthor[]
     */
    public function getBook(): Collection
    {
        return $this->books;
    }

    public function addBook(Book $book): self
    {
        if (!$this->book->contains($book)) {
            $this->books[] = $book;
        }

        return $this;
    }

    public function removeBook(Book $book): self
    {
        $this->book->removeElement($book);

        return $this;
    }
}
