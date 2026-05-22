<?php
declare(strict_types=1);

namespace App\DAO\InterfacesDAO;

use App\Models\Cours;

/**
 * Declares the functions to interact with the database to handle the subjects
 */
interface IMatieresDAO 
{
    /**
     * Gets all subjects
     *
     * @return array An array containing every subjects
     */
    public function getMatieres(): array;
}