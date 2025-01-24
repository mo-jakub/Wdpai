<?php

class Book
{
    private int $id;
    private string $title;
    private string $description;
    private array $tags = [];
    private array $authors = [];
    private array $genres = [];
    private array $comments = [];

    public function __construct() {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getTags(): array
    {
        return $this->tags ?? [];
    }

    public function getGenres(): array
    {
        return $this->genres ?? [];
    }

    public function getAuthors(): array
    {
        return $this->authors ?? [];
    }

    public function setTags(array $tags): void
    {
        $this->tags = $tags;
    }

    public function setAuthors(array $authors): void
    {
        $this->authors = $authors;
    }

    public function setGenres(array $genres): void
    {
        $this->genres = $genres;
    }

    public function setComments(array $comments): void
    {
        $this->comments = $comments;
    }
    
    public function getComments(): array
    {
        return $this->comments ?? [];
    }    
}