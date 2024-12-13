<?php

namespace App\Applications\DayType\Services;

use App\Applications\DayType\Repositories\DayTypeRepositoryInterface;

/**
 * @property DayTypeRepositoryInterface $dayTypeRepository
 */
class DayTypeService implements DayTypeServiceInterface
{
    public function __construct(
        DayTypeRepositoryInterface $dayTypeRepository
    ) {
        $this->dayTypeRepository = $dayTypeRepository;
    }

    public function getAll(): array
    {
        return $this->dayTypeRepository->getAll();
    }

}
