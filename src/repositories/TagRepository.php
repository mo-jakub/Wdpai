<?php

require_once __DIR__ . '/EntityRepository.php';

class TagRepository extends EntityRepository
{
    protected string $tableName = 'tags';
    protected string $entityIdField = 'id_tag';
    protected string $entityNameField = 'tag';
}