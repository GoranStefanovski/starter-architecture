<?php

namespace App\Applications\NationalHoliday\Services;

use App\Applications\NationalHoliday\DTO\NationalHolidayDTO;
use Illuminate\Http\Request;

/**
 * Interface NationalHolidayServiceInterface
 * @package App\Applications\NationalHoliday
 */

interface NationalHolidayServiceInterface
{
    /**
     * @return array
     */
    public function getAll(): array;

    /**
     * @param integer $id
     * @return NationalHolidayDTO
     */
    public function get(int $id): NationalHolidayDTO;

    /**
     * @param NationalHolidayDTO $leaveTypeData
     * @return NationalHolidayDTO
     */
    public function create(NationalHolidayDTO $leaveTypeData): NationalHolidayDTO;

    /**
     * @param int $leaveTypeId
     * @param NationalHolidayDTO $leaveTypeData
     * @return NationalHolidayDTO
     */
    public function update(int $leaveTypeId, NationalHolidayDTO $leaveTypeData): NationalHolidayDTO;

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
