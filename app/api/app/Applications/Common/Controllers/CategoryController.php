<?php

namespace App\Applications\Common\Controllers;

use App\Applications\Common\Model\Category;
use App\Applications\Store\Model\Store;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class CategoryController extends Controller
{
    /**
     * Get all categories for the current user.
     */
    public function getAll(): JsonResponse
    {
        $user = Auth::user();

        // Admins see all categories
            $categories = Category::all();
    

        return response()->json($categories->toArray());
    }

    /**
     * Get a single category by ID.
     */
    public function get(int $id): JsonResponse
    {
        $category = Category::findOrFail($id);

        // Check ownership for non-admins
        $this->authorizeCategoryAccess($category);

        return response()->json($category->toArray());
    }

    /**
     * Create a new category.
     */
    public function create(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug',
            'description' => 'nullable|string',
        ]);

        $user = Auth::user();

        // Find the store owned by the authenticated user
        $store = Store::where('user_id', $user->id)->first();

        if (!$store) {
            return response()->json(['error' => 'No store found for this user'], 404);
        }

        // Check if user owns the store (if not admin)
        if (!$user->hasRole('admin') && $store->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $category = Category::create([
            'name' => $validated['name'],
            'slug' => $validated['slug'] ?? \Str::slug($validated['name']),
            'description' => $validated['description'],
            'user_id' => $user->id,
            'store_id' => $store->id,
        ]);

        return response()->json($category, 201);
    }

    /**
     * Update an existing category.
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => "nullable|string|max:255|unique:categories,slug,{$id}",
            'description' => 'nullable|string',
        ]);

        $category = Category::findOrFail($id);

        // Check ownership for non-admins
        $this->authorizeCategoryAccess($category);

        $category->update($validated);

        return response()->json($category);
    }

    /**
     * Delete a category.
     */
    public function delete(int $id): JsonResponse
    {
        $category = Category::findOrFail($id);

        // Check ownership for non-admins
        $this->authorizeCategoryAccess($category);

        $category->delete();

        return response()->json(null, 204);
    }

    /**
     * Check if the logged-in user can access this category.
     */
    protected function authorizeCategoryAccess(Category $category): void
    {
        $user = Auth::user();

        if (!$user->hasRole('admin') && $category->user_id !== $user->id) {
            abort(403, 'You are not authorized to access this category.');
        }
    }
}
