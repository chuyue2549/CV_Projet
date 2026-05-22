<?php
declare(strict_types=1);

namespace App\Controllers\AdminActions\Interfaces;

/**
 * Declares the functions to execute the action
 */
interface IPageAction
{
    /**
     * Executes the admin action and returns data for the view
     *
     * @return array Associative array containing data for the view
     */
    public function __invoke(): array;
}