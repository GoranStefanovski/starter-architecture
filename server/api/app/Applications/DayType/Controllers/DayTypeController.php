<?php

namespace App\Applications\DayType\Controllers;

use App\Http\Controllers\Controller;
use App\Applications\DayType\Services\DayTypeServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @property DayTypeServiceInterface $dayTypeService
 */
class DayTypeController extends Controller
{
    public function __construct(
        DayTypeServiceInterface $dayTypeService
    ) {
        $this->dayTypeService = $dayTypeService;
    }

    /**
     * Get a JSON with all the day types
     *
     * @return JsonResponse
     */
    public function getAll(): JsonResponse
    {
        $dayTypeDTOs = $this->dayTypeService->getAll();
        return response()->json($dayTypeDTOs);
    }

}
