<?php

namespace App\Applications\VacationDay\Services;

use App\Applications\VacationDay\DTO\VacationDayDTO;

/**
 * Interface VacationDayServiceInterface
 * @package App\Applications\VacationDay
 */

interface VacationDayServiceInterface
{
    /**
     * @return array
     */
    public function getAll(): array;

    /**
     * @param integer $id
     * @return VacationDayDTO
     */
    public function get(int $id): VacationDayDTO;

    /**
     * @param VacationDayDTO $vacationDayData
     * @return VacationDayDTO
     */
    public function create(VacationDayDTO $vacationDayData): VacationDayDTO;

    /**
     * @param int $vacationDayId
     * @param VacationDayDTO $vacationDayData
     * @return VacationDayDTO
     */
    public function update(int $vacationDayId, VacationDayDTO $vacationDayData): VacationDayDTO;

    /**
     * @param integer $id
     * @return boolean
     */
    public function delete(int $id);

    /**
     * @param array $data
     * @return array
     */
    public function draw(array $data): array;
}
