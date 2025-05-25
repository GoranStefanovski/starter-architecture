<?php

namespace App\Applications\Venue\Controllers;

use App\Applications\Venue\DTO\VenueDTO;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Applications\Venue\Services\VenueServiceInterface;
use App\Applications\Venue\Requests\MyProfileRequest;
use App\Applications\Venue\Requests\UpdatePasswordRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @property VenueServiceInterface $venueService
 */
class VenueController extends Controller
{
    public function __construct(
        VenueServiceInterface $venueService
    ) {
        $this->venueService = $venueService;
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
        dd('asdasdasdas');
        $venueDTO = $this->venueService->get($id);
        return response()->json($venueDTO);
    }

    /**
     * Store user and get JSON with a user response
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $venueDTO = VenueDTO::fromRequestForCreate($request);
        $newVenueDTO = $this->venueService->create($venueDTO);

        return response()->json($newVenueDTO);
    }

    /**
     * Update user
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
        $userId = Route::current()->parameter('id');
        $dto = VenueDTO::fromRequest($request);
        $venueDTO = $this->venueService->update(
            $userId,
            $dto
        );
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
            $usersDTO = $this->venueService->draw($data);

            return response()->json($usersDTO);
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
     * Get a JSON of Venue Roles and Permissions.
     *
     * @return JsonResponse
     */
    public function getVenuePermissionsRoles(): JsonResponse
    {
        $permissionsAndRoles = $this->venueService->getVenuePermissionsAndRoles();

        return response()->json($permissionsAndRoles);
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
     * Handle the avatar upload for the authenticated user.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function uploadAvatar(Request $request): JsonResponse
    {
        try {
            $userId = Route::current()->parameter('id');
            $userId = (is_numeric($userId) && (int)$userId > 0)
                ? (int)$userId
                : Auth::id();

            $venueDTO = $this->venueService->uploadAvatar($userId, $request, Auth::user());

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
            Log::error('Error uploading avatar: ' . $e->getMessage(), ['exception' => $e]);

            return response()->json([
                'message' => 'An error occurred while uploading the avatar. Please try again later.',
            ], 500);
        }
    }
}
