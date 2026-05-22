<?php
declare(strict_types=1);

namespace App\Controllers\AdminActions\Interfaces;

/**
 * Declares the functions to execute the action
 */
interface ICommandAction
{
    /**
     * Executes the admin action
     *
     * @return void
     */
    public function __invoke(): void;
}