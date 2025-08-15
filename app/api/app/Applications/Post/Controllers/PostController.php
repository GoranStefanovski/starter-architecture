<?php

namespace App\Applications\Post\Controllers;

use App\Applications\Post\DTO\PostDTO;
use App\Applications\Post\Model\Post;
use App\Applications\Post\Services\PostServiceInterface;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;


/**
 * @property PostServiceInterface $postService
 */
class PostController extends Controller
{
    public function __construct(
        PostServiceInterface $postService
    ) {
        $this->postService = $postService;
    }

    /**
     * Get a JSON with all the users
     *
     * @return JsonResponse
     */
    public function getAll(): JsonResponse
    {
        $PostDTOs = $this->postService->getAll();
        return response()->json($PostDTOs);
    }

    /**
     * Get a JSON with a user by ID
     *
     * @param  integer  $id
     * @return JsonResponse
     */
    public function get(int $id): JsonResponse
    {
        $PostDTO = $this->postService->get($id);
        return response()->json($PostDTO);
    }

    /**
     * Store user and get JSON with a user response
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $PostDTO = PostDTO::fromRequest($request);
        $newPostDTO = $this->postService->create($PostDTO);

        return response()->json($newPostDTO);
    }

    /**
     * Update user
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function update(Request $request,$postId): JsonResponse
    {
        $dto = PostDTO::fromRequest($request);
        $PostDTO = $this->postService->update($postId,$dto);
        return response()->json($PostDTO);
    }

    /**
     * Delete user
     *
     * @return string
     */
    public function delete()
    {
        $userId = Route::current()->parameter('id');
        return $this->postService->delete($userId);
    }

    /**
     * Get a paginated, filtered and sorted array of Posts.
     * This endpoint requires some data in the request.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function draw(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $postsDTO = $this->postService->draw($data);

            return response()->json($postsDTO);
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
    public function uploadPostImage(Request $request): JsonResponse
    {
        try {
            $postId = Route::current()->parameter('id');
            $PostDTO = $this->postService->uploadAvatar($postId, $request);

            return response()->json($PostDTO, 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation error.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e) {
            return response()->json([
                'message' => 'Post not found.',
            ], 404);
        } catch (AuthorizationException $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 403);
        } catch (\Exception $e) {
            Log::error('Error uploading post image: ' . $e->getMessage(), ['exception' => $e]);

            return response()->json([
                'message' => 'An error occurred while uploading the post image. Please try again later.',
            ], 500);
        }
    }
}
