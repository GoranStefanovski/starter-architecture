<?php

namespace App\Applications\DayType\Repositories;

use App\Applications\DayType\DTO\DayTypeDTO;
use App\Applications\DayType\Model\DayType;


/**
 * @property DayType $dayType
 */

 class DayTypeRepository implements DayTypeRepositoryInterface
{
    public function __construct(
        DayType $dayType,
    ) {
        $this->dayType = $dayType;
    }

    public function getAll(): array
    {
        $dayTypes = $this->dayType::all();
        return DayTypeDTO::fromCollection($dayTypes);
    }
}
