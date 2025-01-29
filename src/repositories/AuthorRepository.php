<?php

require_once __DIR__ . '/EntityRepository.php';

class AuthorRepository extends EntityRepository
{
    protected string $tableName = 'authors';
    protected string $entityIdField = 'id_author';
    protected string $entityNameField = 'author';
}