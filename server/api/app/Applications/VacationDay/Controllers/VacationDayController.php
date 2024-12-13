<?php

namespace App\Applications\VacationDay\Controllers;

use App\Applications\VacationDay\DTO\VacationDayDTO;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Applications\VacationDay\Services\VacationDayServiceInterface;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @property VacationDayServiceInterface $vacationDayService
 */
class VacationDayController extends Controller
{
    public function __construct(
        VacationDayServiceInterface $vacationDayService
    ) {
        $this->vacationDayService = $vacationDayService;
    }

    /**
     * Get a JSON with all the vacationDays
     *
     * @return JsonResponse
     */
    public function getAll(): JsonResponse
    {
        $vacationDayDTOs = $this->vacationDayService->getAll();
        return response()->json($vacationDayDTOs);
    }

    /**
     * Get a JSON with a vacationDay by ID
     *
     * @param  integer  $id
     * @return JsonResponse
     */
    public function get(int $id): JsonResponse
    {
        $vacationDayDTO = $this->vacationDayService->get($id);
        return response()->json($vacationDayDTO);
    }

    /**
     * Store vacationDay and get JSON with a vacationDay response
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $vacationDayDTO = VacationDayDTO::fromRequestForCreate($request);
        $newVacationDayDTO = $this->vacationDayService->create($vacationDayDTO);

        return response()->json($newVacationDayDTO);
    }

    /**
     * Update vacationDay
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
        $vacationDayId = Route::current()->parameter('id');
        $dto = VacationDayDTO::fromRequest($request);
        $vacationDayDTO = $this->vacationDayService->update(
            $vacationDayId,
            $dto
        );
        return response()->json($vacationDayDTO);
    }

    /**
     * Delete vacationDay
     *
     * @return string
     */
    public function delete()
    {
        $vacationDayId = Route::current()->parameter('id');
        return $this->vacationDayService->delete($vacationDayId);
    }

    /**
     * Get a paginated, filtered and sorted array of VacationDays.
     * This endpoint requires some data in the request.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function draw(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $vacationDaysDTO = $this->vacationDayService->draw($data);

            return response()->json($vacationDaysDTO);
        } catch (\InvalidArgumentException $e) {
            // Handle specific exceptions like InvalidArgumentException
            return response()->json([
                'error' => 'Invalid Argument',
                'message' => $e->getMessage(),
            ], 400); // Bad Request status code
        } catch (\ValidationException $e) {
            // Handle validation exceptions
            return response()->json([
                'error' => 'Validation Error',
                'message' => $e->getMessage(),
                'errors' => $e->errors(),
            ], 422); // Unprocessable Entity status code
        } catch (\Exception $e) {
            // Handle any other general exceptions
            return response()->json([
                'error' => 'Server Error',
                'message' => $e->getMessage(),
            ], 500); // Internal Server Error status code
        }
    }
}
