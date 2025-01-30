<?php

/**
 * Class Book
 *
 * Represents a book entity with properties such as title, description,
 * cover image path, and relationships with tags, authors, genres, and comments.
 * Provides getter and setter methods to access and modify its data.
 */
class Book
{
    /**
     * @var int The unique identifier of the book.
     */
    private int $id;

    /**
     * @var string The title of the book.
     */
    private string $title;

    /**
     * @var string The description or summary of the book.
     */
    private string $description;

    /**
     * @var string|null The file path to the book's cover image, if available.
     */
    private ?string $cover;

    /**
     * @var array List of tags associated with the book.
     */
    private array $tags = [];

    /**
     * @var array List of authors who contributed to the book.
     */
    private array $authors = [];

    /**
     * @var array List of genres that categorize the book.
     */
    private array $genres = [];

    /**
     * @var array List of comments or reviews related to the book.
     */
    private array $comments = [];

    /**
     * Book constructor.
     *
     * Initializes the Book object. Values for the properties can be
     * set using their respective setter methods.
     */
    public function __construct() {}

    /**
     * Gets the unique identifier of the book.
     *
     * @return int The book's unique ID.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Gets the title of the book.
     *
     * @return string The book's title.
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Gets the description or summary of the book.
     *
     * @return string The book's description.
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Gets the cover image path of the book.
     *
     * @return string|null The path to the cover image, or null if not available.
     */
    public function getCover(): ?string
    {
        return $this->cover;
    }

    /**
     * Gets the list of tags associated with the book.
     *
     * @return array An array of tags.
     */
    public function getTags(): array
    {
        return $this->tags ?? [];
    }

    /**
     * Gets the list of genres associated with the book.
     *
     * @return array An array of genres.
     */
    public function getGenres(): array
    {
        return $this->genres ?? [];
    }

    /**
     * Gets the list of authors associated with the book.
     *
     * @return array An array of authors.
     */
    public function getAuthors(): array
    {
        return $this->authors ?? [];
    }

    /**
     * Gets the list of comments or reviews related to the book.
     *
     * @return array An array of comments.
     */
    public function getComments(): array
    {
        return $this->comments ?? [];
    }

    /**
     * Sets the tags associated with the book.
     *
     * @param array $tags An array of tags to associate with the book.
     * @return void
     */
    public function setTags(array $tags): void
    {
        $this->tags = $tags;
    }

    /**
     * Sets the authors who contributed to the book.
     *
     * @param array $authors An array of authors to associate with the book.
     * @return void
     */
    public function setAuthors(array $authors): void
    {
        $this->authors = $authors;
    }

    /**
     * Sets the genres that categorize the book.
     *
     * @param array $genres An array of genres to associate with the book.
     * @return void
     */
    public function setGenres(array $genres): void
    {
        $this->genres = $genres;
    }

    /**
     * Sets the comments or reviews related to the book.
     *
     * @param array $comments An array of comments to associate with the book.
     * @return void
     */
    public function setComments(array $comments): void
    {
        $this->comments = $comments;
    }
}