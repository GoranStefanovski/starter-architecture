<?php

namespace App\Applications\LeaveRequest\Repositories;

use App\Applications\LeaveRequest\DTO\LeaveRequestDTO;
use App\Applications\Pagination\StarterPaginator;
use App\Applications\LeaveRequest\Model\LeaveRequest;


/**
 * @property LeaveRequest $leaveRequest
 */
class LeaveRequestRepository implements LeaveRequestRepositoryInterface
{
    public function __construct(
        LeaveRequest $leaveRequest,
    ) {
        $this->leaveRequest = $leaveRequest;
    }

    private const COLUMNS_MAP = [
        'first_name' => 'leave_requests.first_name',
        'last_name' => 'leave_requests.last_name',
        'email' => 'leave_requests.email',
        'roles' => 'roles.id',
        'status' => 'leave_requests.is_disabled'
    ];

    public function getAll(): array
    {
        $leaveRequests = $this->leaveRequest::all();
        return LeaveRequestDTO::fromCollection($leaveRequests);
    }

    public function get($id): LeaveRequest
    {
        return $this->leaveRequest::findOrFail($id);
    }

    public function create(LeaveRequestDTO $leaveRequestDTO): LeaveRequest
    {
        $attributes = $leaveRequestDTO->toArray();

        $leaveRequest = new LeaveRequest($attributes);
        $leaveRequest->save();

        return $leaveRequest;
    }

    public function update(int $userId, LeaveRequestDTO $userData): LeaveRequest
    {
        $leaveRequest = $this->leaveRequest->findOrFail($userId);
        $attributes = $userData->toArray();
        $leaveRequest->update($attributes);
        return $leaveRequest;
    }

    public function delete(int $id)
    {
        return $this->leaveRequest::findOrFail($id)->delete();
    }

    public function draw($data): StarterPaginator
    {
        //        $paginatedUsers = $this->prepareDatatableQuery($data, [User::ADMIN, User::EDITOR, User::COLLABORATOR]);

        $query = $this->leaveRequest->query();

        // $query->whereIn('roles.name', $roles);

        if (array_key_exists($data['column'], self::COLUMNS_MAP)) {
            $query->orderBy(self::COLUMNS_MAP[$data['column']], $data['dir']);
        }

        $search = $data['search'];
        if ($search) {
            $query->where(function ($subquery) use ($search) {
                $subquery->where('users.first_name', 'like', '%' . $search . '%');
                $subquery->orWhere('users.last_name', 'like', '%' . $search . '%');
                $subquery->orWhere('users.email', 'like', '%' . $search . '%');
                $subquery->orWhere('roles.name', 'like', '%' . $search . '%');
            });
        }

        $query->whereNull('deleted_at');

        return $query->paginate($data['length']);
    }
}
