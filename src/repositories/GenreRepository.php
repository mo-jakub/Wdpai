<?php

require_once __DIR__ . '/EntityRepository.php';

class GenreRepository extends EntityRepository
{
    protected string $tableName = 'genres';
    protected string $entityIdField = 'id_genre';
    protected string $entityNameField = 'genre';
}