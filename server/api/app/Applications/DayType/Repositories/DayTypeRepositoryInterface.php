<?php

namespace App\Applications\DayType\Repositories;

/**
 * Interface DayTypeRepositoryInterface
 * @package App\Applications\DayType
 */

interface DayTypeRepositoryInterface
{
    /**
     * @return array
     */
    public function getAll(): array;

}
