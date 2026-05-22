<?php
declare(strict_types=1);

namespace App\DAO\InterfacesDAO;

use App\Models\Contenu;

/**
 * Declares the functions to interact with the database to handle the contents
 */
interface IContenuDAO
{
    /**
     * Creates a content entry and returns its ID
     *
     * @param Contenu $contenu The content to create
     * @return int The generated ID
     */
    public function create(Contenu $contenu): int;

    /**
     * Gets a content by its is
     *
     * @param integer $id The content id
     * @return Contenu|null The content or null if not found
     */
    public function getById(int $id): ?Contenu;
}