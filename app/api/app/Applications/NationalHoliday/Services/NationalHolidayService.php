<?php

namespace App\Applications\NationalHoliday\Services;

use App\Applications\NationalHoliday\DTO\NationalHolidayDTO;
use App\Applications\NationalHoliday\Repositories\NationalHolidayRepositoryInterface;

/**
 * @property NationalHolidayRepositoryInterface $leaveTypeRepository
 */
class NationalHolidayService implements NationalHolidayServiceInterface
{
    public function __construct(
        NationalHolidayRepositoryInterface $leaveTypeRepository
    ) {
        $this->leaveTypeRepository = $leaveTypeRepository;
    }

    public function getAll(): array
    {
        return $this->leaveTypeRepository->getAll();
    }

    public function get($id): NationalHolidayDTO
    {
        return NationalHolidayDTO::fromModel(
            $this->leaveTypeRepository->get($id)
        );
    }

    public function create(NationalHolidayDTO $leaveTpyeData): NationalHolidayDTO
    {
        $leaveType = $this->leaveTypeRepository->create($leaveTpyeData);
        return NationalHolidayDTO::fromModel($leaveType);
    }

    public function update(int $leaveTypeId, NationalHolidayDTO $leaveTpyeData): NationalHolidayDTO
    {
        $leaveType = $this->leaveTypeRepository->update($leaveTypeId, $leaveTpyeData);
        return NationalHolidayDTO::fromModel($leaveType);
    }

    public function delete(int $id)
    {
        return $this->leaveTypeRepository->delete($id);
    }

    public function draw(array $data): array
    {
        $data['columns'] = ['users.first_name', 'users.last_name', 'email', 'roles.id', 'users.is_disabled'];
        $data['length'] = $data['length'] ?? 25;
        $data['column'] = $data['column'] ?? 'users.first_name';
        $data['dir'] = $data['dir'] ?? 'asc';
        $data['isCountry'] = $data['isCountry'] ?? '';
        $data['search'] = $data['search'] ?? '';
        $data['draw'] = $data['draw'] ?? 1;

        $usersCollection = $this->leaveTypeRepository->draw($data);
        $usersDTOs = $usersCollection->getCollection()->map(function ($user) {
            return NationalHolidayDTO::fromModel($user);
        });

        return [
            'data' => $usersDTOs,
            'pagination' => $usersCollection->toArray()['pagination'],
        ];
    }
}
