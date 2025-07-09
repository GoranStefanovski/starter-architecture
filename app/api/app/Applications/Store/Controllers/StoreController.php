<?php

namespace App\Applications\Store\Controllers;

use App\Applications\Store\DTO\StoreDTO;
use App\Applications\Store\Model\Store;
use App\Applications\Store\Services\StoreService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    protected $storeService;

    public function __construct(StoreService $storeService)
    {
        $this->storeService = $storeService;
    }

    public function getAll()
    {
        $stores = $this->storeService->getAllStores();
        return response()->json($stores->map->toArray());
    }

    public function get($id)
    {
        $store = $this->storeService->getStoreById($id);
        return response()->json($store->toArray());
    }

    public function create(Request $request)
    {
        $storeDTO = StoreDTO::fromRequest($request);
        $store = $this->storeService->createStore($storeDTO->toArray());
        return response()->json($store, 201);
    }

    public function update(Request $request)
    {
        $storeId = Route::current()->parameter('id');
        $storeDTO = StoreDTO::fromRequest($request);
        $updatedStore = $this->storeService->updateStore($storeId, $storeDTO->toArray());
        return response()->json($updatedStore);
    }

    public function delete(Store $store)
    {
        $this->storeService->deleteStore($store);
        return response()->json(null, 204);
    }

    /**
     * Attach a store entry to another model (morph it).
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function attachToModel(int $id, Request $request)
    {
        $validated = $request->validate([
            'model_id' => 'required|integer',
            'model_type' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    $allowedModelTypes = array_keys(config('store.model_types'));

                    if (!in_array($value, $allowedModelTypes, true)) {
                        $fail("The selected $attribute is invalid.");
                    }
                },
            ],
        ]);

        // Convert alias to the full namespace
        $modelType = config('store.model_types')[$validated['model_type']];

        $store = $this->storeService->attachToModel($id, $validated['model_id'], $modelType);

        return response()->json($store->toArray());
    }

    /**
     * Detach the morphable model from a store entry.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function detachModel(int $id): JsonResponse
    {
        $store = $this->storeService->detachModel($id);

        return response()->json($store->toArray());
    }

    public function getAncestors(int $id)
    {
        $ancestors = $this->storeService->getAncestors($id);
        return response()->json($ancestors);
    }

    public function getDescendants(int $id)
    {
        $descendants = $this->storeService->getDescendants($id);
        return response()->json($descendants);
    }
}
