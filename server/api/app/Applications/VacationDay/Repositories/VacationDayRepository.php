<?php

namespace App\Applications\VacationDay\Repositories;

use App\Applications\VacationDay\DTO\VacationDayDTO;
use App\Applications\Pagination\StarterPaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\UploadedFile;
use App\Applications\VacationDay\Model\VacationDay;
use Spatie\Permission\Models\Role;
use Spatie\MediaLibrary\MediaCollections\Models\Media;


/**
 * @property VacationDay $vacationDay
 */
class VacationDayRepository implements VacationDayRepositoryInterface
{
    public function __construct(
        VacationDay $vacationDay,
    ) {
        $this->vacationDay = $vacationDay;
    }

    private const COLUMNS_MAP = [
        'first_name' => 'vacationDay.first_name',
        'last_name' => 'vacationDay.last_name',
        'email' => 'vacationDay.email',
        'roles' => 'role.id',
        'status' => 'vacationDay.is_disabled'
    ];

    public function getAll(): array
    {
        $vacationDays = $this->vacationDay::all();
        return VacationDayDTO::fromCollection($vacationDays);
    }

    public function get($id): VacationDay
    {
        return $this->vacationDay::findOrFail($id);
    }

    public function create(VacationDayDTO $vacationDayDTO): VacationDay
    {
        $attributes = $vacationDayDTO->toArray();

        $vacationDay = new VacationDay($attributes);
        $vacationDay->save();

        return $vacationDay;
    }

    public function update(int $vacationDayId, VacationDayDTO $vacationDayData): VacationDay
    {
        $vacationDay = $this->vacationDay->findOrFail($vacationDayId);
        $attributes = $vacationDayData->toArray();
        $vacationDay->update($attributes);
        return $vacationDay;
    }

    public function delete(int $id)
    {
        return $this->vacationDay::findOrFail($id)->delete();
    }

    public function draw($data): StarterPaginator
    {
        $query = $this->vacationDay->query();

        if (array_key_exists($data['column'], self::COLUMNS_MAP)) {
            $query->orderBy(self::COLUMNS_MAP[$data['column']], $data['dir']);
        }

        $search = $data['search'];
        if ($search) {
            $query->where(function ($subquery) use ($search) {
                $subquery->where('vacation_days.first_name', 'like', '%' . $search . '%');
                $subquery->orWhere('vacation_days.last_name', 'like', '%' . $search . '%');
                $subquery->orWhere('vacation_days.email', 'like', '%' . $search . '%');
                $subquery->orWhere('roles.name', 'like', '%' . $search . '%');
            });
        }

        $query->whereNull('deleted_at');

        return $query->paginate($data['length']);
    }
}
