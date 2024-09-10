<?php

namespace App\Entity;

use App\Repository\WishRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WishRepository::class)]
class Wish
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 250)]
    #[ORM\Column(type:"string", length:250)]
    #[Assert\NotBlank(message:"Please provide an idea!")]
    #[Assert\Length(
     min:5,
     max:250,
     minMessage:"Minimum 5 characters please!",
     maxMessage:"Maximum 250 characters please!"
)]
    private ?string $title = null;

   #[ORM\Column(type:"text", nullable:true)]
#[Assert\Length(
    min:5,
    max:5000,
    minMessage:"Minimum 5 characters please!",
     maxMessage:"Maximum 5000 characters please!"
)]
    private ?string $description = null;

#[Assert\NotBlank(message:"Please provide your username!")]
#[Assert\Length(
     min:3,
     max:50,
     minMessage:"Minimum 3 characters please!",
     maxMessage:"Maximum 50 characters please!"
 )]
#[Assert\Regex(pattern:"/^[a-z0-9_-]+$/i",
    message:"Please use only letters, numbers, underscores and dashes!")]

    private ?string $author = null;

    #[ORM\Column]
    private ?bool $isPublished = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateCreated = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function isPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setPublished(bool $isPublished): static
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->dateCreated;
    }

    public function setDateCreated(\DateTimeInterface $dateCreated): static
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }
}
