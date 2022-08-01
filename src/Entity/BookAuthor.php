<?php

namespace App\Entity;

use App\Repository\BookAuthorRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookAuthorRepository::class)]
class BookAuthor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $bookId;

    #[ORM\Column(type: 'integer')]
    private $authorId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBookId(): ?int
    {
        return $this->bookId;
    }

    public function setBookId(int $bookId): self
    {
        $this->bookId = $bookId;

        return $this;
    }

    public function getAuthorId(): ?int
    {
        return $this->authorId;
    }

    public function setAuthorId(int $authorId): self
    {
        $this->authorId = $authorId;

        return $this;
    }
}
