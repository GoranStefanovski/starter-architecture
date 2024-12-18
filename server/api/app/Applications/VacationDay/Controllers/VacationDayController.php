<?php

namespace App\Applications\VacationDay\Controllers;

use App\Applications\VacationDay\DTO\VacationDayDTO;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Applications\VacationDay\Services\VacationDayServiceInterface;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class VacationDayController extends Controller
{
    private VacationDayServiceInterface $vacationDayService;

    public function __construct(VacationDayServiceInterface $vacationDayService)
    {
        $this->vacationDayService = $vacationDayService;
    }

    /**
     * Get a JSON with all the vacationDays
     */
    public function getAll(): JsonResponse
    {
        $vacationDayDTOs = $this->vacationDayService->getAll();
        return response()->json($vacationDayDTOs, 200);
    }

    /**
     * Get a JSON with a vacationDay by ID
     */
    public function get(int $id): JsonResponse
    {
        $vacationDayDTO = $this->vacationDayService->get($id);

        if (!$vacationDayDTO) {
            return response()->json(['error' => 'Vacation Day not found'], 404);
        }

        return response()->json($vacationDayDTO, 200);
    }

    /**
     * Store vacationDay and get JSON with a vacationDay response
     */
    public function create(Request $request): JsonResponse
    {   
        $validated = $this->validateRequest($request);
        $vacationDayDTO = VacationDayDTO::fromRequestForCreate($validated);
        $newVacationDayDTO = $this->vacationDayService->create($vacationDayDTO);

        return response()->json($newVacationDayDTO, 201); // 201 for resource created
    }

    /**
     * Update vacationDay
     */
    public function update(Request $request): JsonResponse
    {
        $vacationDayId = Route::current()->parameter('id');
        $validated = $this->validateRequest($request);

        $dto = VacationDayDTO::fromRequest($validated);
        $updatedVacationDayDTO = $this->vacationDayService->update($vacationDayId, $dto);

        return response()->json($updatedVacationDayDTO, 200);
    }

    /**
     * Delete vacationDay
     */
    public function delete(): JsonResponse
    {
        $vacationDayId = Route::current()->parameter('id');

        $result = $this->vacationDayService->delete($vacationDayId);

        if (!$result) {
            return response()->json(['error' => 'Failed to delete vacation day'], 400);
        }

        return response()->json(['message' => 'Vacation day deleted successfully'], 200);
    }

    /**
     * Get a paginated, filtered and sorted array of VacationDays
     */
    public function draw(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $vacationDaysDTO = $this->vacationDayService->draw($data);

            return response()->json($vacationDaysDTO, 200);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['error' => 'Invalid Argument', 'message' => $e->getMessage()], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Server Error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Validate the incoming request for VacationDay
     */
    private function validateRequest(Request $request): array
    {
        return $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'date_from' => 'required|date',
            'date_to' => 'required|date|after_or_equal:date_from',
            'year' => 'required|integer|min:2000|max:' . date('Y'),
            'day_type_id' => 'required|integer|in:1,2,3,4,5',
            'handler_id' => 'required|integer|exists:users,id',
        ]);
    }
}
