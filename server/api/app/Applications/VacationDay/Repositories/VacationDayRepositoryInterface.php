<?php

namespace App\Applications\VacationDay\Repositories;

use App\Applications\Pagination\StarterPaginator;
use App\Applications\VacationDay\DTO\VacationDayDTO;
use App\Applications\VacationDay\Model\VacationDay;
use Illuminate\Database\Eloquent\Collection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Http\UploadedFile;

/**
 * Interface VacationDayRepositoryInterface
 * @package App\Applications\VacationDay
 */

interface VacationDayRepositoryInterface
{
    /**
     * @return array
     */
    public function getAll(): array;

    /**
     * @param integer $id
     * @return VacationDay
     */
    public function get($id);

    /**
     * @param VacationDayDTO $vacationDay
     * @return VacationDay
     */
    public function create(VacationDayDTO $vacationDay): VacationDay;

    /**
     * @param int $vacationDayId
     * @param VacationDayDTO $vacationDayData
     * @return VacationDay
     */
    public function update(int $vacationDayId, VacationDayDTO $vacationDayData): VacationDay;

    /**
     * @param integer $id
     * @return boolean
     */
    public function delete(int $id);

    /**
     * @param array $data
     * @return StarterPaginator
     */
    public function draw(array $data): StarterPaginator;

}
