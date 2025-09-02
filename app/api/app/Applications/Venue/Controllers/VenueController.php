<?php

namespace App\Applications\Venue\Controllers;

use App\Applications\Venue\DTO\VenueDTO;
use App\Applications\WorkingHours\Services\WorkingHoursServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Applications\Venue\Services\VenueServiceInterface;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Applications\Venue\Requests\VenueRequest;

/**
 * @property VenueServiceInterface $venueService
 * @property WorkingHoursServiceInterface $workingHoursService
 */
class VenueController extends Controller
{
    public function __construct(
        VenueServiceInterface $venueService,
        WorkingHoursServiceInterface $workingHoursService,

    ) {
        $this->venueService = $venueService;
        $this->workingHoursService = $workingHoursService;
    }

    /**
     * Get a JSON with all the users
     *
     * @return JsonResponse
     */
    public function getAll(): JsonResponse
    {
        $venueDTOs = $this->venueService->getAll();
        return response()->json($venueDTOs);
    }

    /**
     * Get a JSON with a user by ID
     *
     * @param  integer  $id
     * @return JsonResponse
     */
    public function get(int $id): JsonResponse
    {
        $venueDTO = $this->venueService->get($id);
        return response()->json($venueDTO);
    }

    /**
     * Store user and get JSON with a user response
     *
     * @param  VenueRequest  $request
     * @return JsonResponse
     */
    public function create(VenueRequest $request): JsonResponse
    {
        $venueDTO = VenueDTO::fromRequestForCreate($request);
        $newVenueDTO = $this->venueService->create($venueDTO,);
        $this->workingHoursService->createOrUpdateForVenue($venueDTO->id,$request->input('working_hours'));

        return response()->json($newVenueDTO);
    }

    /**
     * Update user
     *
     * @param  VenueRequest  $request
     * @return JsonResponse
     */
    public function update(VenueRequest $request): JsonResponse
    {
        $dto = VenueDTO::fromRequest($request);
        $venueDTO = $this->venueService->update(
            $dto->id,
            $dto,
        );
        $this->workingHoursService->createOrUpdateForVenue($venueDTO->id,$request->input('working_hours'));

        return response()->json($venueDTO);
    }

    /**
     * Delete user
     *
     * @return string
     */
    public function delete()
    {
        $userId = Route::current()->parameter('id');
        return $this->venueService->delete($userId);
    }

    /**
     * Get a paginated, filtered and sorted array of Venues.
     * This endpoint requires some data in the request.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function draw(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $venuesDTO = $this->venueService->draw($data);

            return response()->json($venuesDTO);
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

    /**
     * Get a JSON for the logged in user
     *
     * @return string
     */
    public function getMyProfile()
    {
        $venueDTO = $this->venueService->get(
            Auth::user()->id
        );
        return response()->json($venueDTO);
    }

    /**
     * Handle images upload for a Venue
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function uploadVenueImage(Request $request): JsonResponse
    {
        try {
            $venueId = Route::current()->parameter('id');
            $venueDTO = $this->venueService->uploadVenueImage($venueId, $request);

            return response()->json($venueDTO, 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation error.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e) {
            return response()->json([
                'message' => 'Venue not found.',
            ], 404);
        } catch (AuthorizationException $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 403);
        } catch (\Exception $e) {
            Log::error('Error uploading venue image: ' . $e->getMessage(), ['exception' => $e]);

            return response()->json([
                'message' => 'An error occurred while uploading the venue image. Please try again later.',
            ], 500);
        }
    }

    public function deleteVenueImage($venueId,$imageId): JsonResponse{
        return response()->json($this->venueService->deleteVenueImage((int)$venueId,(int)$imageId));
    }


    /**
     * Get a JSON with venues in a city
     *
     * @return JsonResponse
     */
    public function getByCityAndOwner(String $city): JsonResponse
    {
        $venueDTOs = $this->venueService->getAllVenuesFromCityOrOwner($city);
        return response()->json($venueDTOs);
    }

}
