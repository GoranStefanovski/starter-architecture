<?php

namespace App\Applications\VacationDay\Services;

use App\Applications\VacationDay\DTO\VacationDayDTO;
use App\Applications\VacationDay\Repositories\VacationDayRepositoryInterface;

/**
 * @property VacationDayRepositoryInterface $vacationDayRepository
 */
class VacationDayService implements VacationDayServiceInterface
{
    public function __construct(
        VacationDayRepositoryInterface $vacationDayRepository
    ) {
        $this->vacationDayRepository = $vacationDayRepository;
    }

    public function getAll(): array
    {
        return $this->vacationDayRepository->getAll();
    }

    public function get($id): VacationDayDTO
    {
        return VacationDayDTO::fromModel(
            $this->vacationDayRepository->get($id)
        );
    }

    public function create(VacationDayDTO $vacationDayData): VacationDayDTO
    {
        $vacationDay = $this->vacationDayRepository->create($vacationDayData);

        // $roleIds = [$vacationDayData->role];
        // $vacationDay->roles()->attach($roleIds);

        return VacationDayDTO::fromModel($vacationDay);
    }

    public function update(int $vacationDayId, VacationDayDTO $vacationDayData): VacationDayDTO
    {
        $this->vacationDayRepository->changeRole($vacationDayId, $vacationDayData->role);
        $vacationDay = $this->vacationDayRepository->update($vacationDayId, $vacationDayData);
        return VacationDayDTO::fromModel($vacationDay);
    }

    public function delete(int $id)
    {
        return $this->vacationDayRepository->delete($id);
    }

    public function draw(array $data): array
    {
        $data['columns'] = ['vacation_day.year', 'vacation_day.day_type_id'];
        $data['length'] = $data['length'] ?? 10;
        $data['column'] = $data['column'] ?? 'vacation_day.user_id';
        $data['dir'] = $data['dir'] ?? 'asc';
        $data['search'] = $data['search'] ?? '';
        $data['draw'] = $data['draw'] ?? 1;

        $vacationDaysCollection = $this->vacationDayRepository->draw($data);

        $vacationDaysDTOs = $vacationDaysCollection->getCollection()->map(function ($user) {
            return VacationDayDTO::fromModel($user);
        });

        return [
            'data' => $vacationDaysDTOs,
            'pagination' => $vacationDaysCollection->toArray()['pagination'],
        ];
    }
}
