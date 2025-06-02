<?php

namespace App\Applications\Event\Controllers;

use App\Applications\Event\DTO\EventDTO;
use App\Applications\Event\Services\EventServiceInterface;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;


/**
 * @property EventServiceInterface $eventService
 */
class EventController extends Controller
{
    public function __construct(
        EventServiceInterface $eventService
    ) {
        $this->eventService = $eventService;
    }

    /**
     * Get a JSON with all the users
     *
     * @return JsonResponse
     */
    public function getAll(): JsonResponse
    {
        $EventDTOs = $this->eventService->getAll();
        return response()->json($EventDTOs);
    }

    /**
     * Get a JSON with a user by ID
     *
     * @param  integer  $id
     * @return JsonResponse
     */
    public function get(int $id): JsonResponse
    {
        $EventDTO = $this->eventService->get($id);
        return response()->json($EventDTO);
    }

    /**
     * Store user and get JSON with a user response
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $EventDTO = EventDTO::fromRequest($request);

        $newEventDTO = $this->eventService->create($EventDTO);

        return response()->json($newEventDTO);
    }

    /**
     * Update user
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function update(Request $request,$eventId): JsonResponse
    {
        $dto = EventDTO::fromRequest($request);
        $EventDTO = $this->eventService->update($eventId,$dto);
        return response()->json($EventDTO);
    }

    /**
     * Delete user
     *
     * @return string
     */
    public function delete()
    {
        $userId = Route::current()->parameter('id');
        return $this->eventService->delete($userId);
    }

    /**
     * Get a paginated, filtered and sorted array of Events.
     * This endpoint requires some data in the request.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function draw(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $eventsDTO = $this->eventService->draw($data);

            return response()->json($eventsDTO);
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

    //TODO: change this to event image or something
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

            $EventDTO = $this->eventService->uploadAvatar($userId, $request, Auth::user());

            return response()->json($EventDTO, 200);
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
