<?php

namespace App\Applications\Store\Services;

use App\Applications\Store\DTO\StoreDTO;
use App\Applications\Store\Repositories\StoreRepositoryInterface;
use App\Applications\Store\Model\Store;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class StoreService implements StoreServiceInterface
{
    /**
     * @var StoreRepositoryInterface
     */
    protected StoreRepositoryInterface $repository;

    /**
     * StoreService constructor.
     *
     * @param  StoreRepositoryInterface  $repository
     */
    public function __construct(StoreRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Retrieve all stores as DTOs.
     *
     * @return Collection|StoreDTO[]
     */
    public function getAllStores(): Collection
    {
        $stores = $this->repository->all();

        // Transform each store into a DTO
        return new Collection(StoreDTO::fromCollection($stores));
    }

    /**
     * Retrieve a single store by its ID.
     *
     * @param  int  $id
     * @return StoreDTO
     */
    public function getStoreById(int $id): StoreDTO
    {
        $store = $this->repository->findById($id);
        return StoreDTO::fromModel($store);
    }

    /**
     * Create a new store.
     *
     * @param  array<string, mixed>  $data
     * @return Store
     */
    public function createStore(array $data): Store
    {
        return $this->repository->create($data);
    }

    /**
     * Update an existing store.
     *
     * @param  int  $storeId
     * @param  array<string, mixed>  $data
     * @return Store
     */
    public function updateStore(int $storeId, array $data): Store
    {
        return $this->repository->update($storeId, $data);
    }

    /**
     * Delete a store.
     *
     * @param Store $store
     * @return bool|null
     * @throws Exception
     */
    public function deleteStore(Store $store): ?bool
    {
        return $this->repository->delete($store);
    }

    /**
     * Attach a store entry to another model (morph it).
     *
     * @param int $storeId
     * @param int $modelId
     * @param string $modelType
     * @return Store
     * @throws Exception
     */
    public function attachToModel(int $storeId, int $modelId, string $modelType): Store
    {
        // Fetch the store entry
        $store = $this->repository->findById($storeId);

        if (!$store) {
            throw new Exception("Store entry not found");
        }

        // Dynamically resolve and find the model instance
        if (!class_exists($modelType)) {
            throw new Exception("Invalid model type: {$modelType}");
        }

        $model = $modelType::findOrFail($modelId);

        // Attach the morphable model
        $store->content()->associate($model);
        $store->save();

        return $store;
    }

    /**
     * Detach the morphable model from a store entry.
     *
     * @param int $storeId
     * @return Store
     * @throws Exception
     */
    public function detachModel(int $storeId): Store
    {
        $store = $this->repository->findById($storeId);

        if (!$store) {
            throw new Exception("Store entry not found");
        }

        // Detach the morphable model
        $store->content()->dissociate();
        $store->save();

        return $store;
    }

    public function getAncestors(int $id): Collection
    {
        $ancestors = $this->repository->findAncestors($id);

        $ancestors->each(function ($ancestor) {
            return StoreDTO::fromModel($ancestor);
        });

        return $ancestors;
    }

    public function getDescendants(int $id): Collection
    {
        $descendants = $this->repository->findDescendants($id);

        $descendants->each(function ($descendant) {
            return StoreDTO::fromModel($descendant);
        });

        return $descendants;
    }

    /**
     * Fetch all visible stores that are currently live.
     *
     * @return array
     */
    public function getLiveStores(): array
    {
        $stores = $this->repository->findLiveStores();

        return StoreDTO::fromCollection($stores);
    }

    public function createStoreAndAttach(StoreDTO $storeDTO, int $modelId, string $modelType): StoreDTO
    {
        $store = $this->repository->create($storeDTO->toArray());

        $this->attachToModel($store->id, $modelId, $modelType);

        return StoreDTO::fromModel($store);
    }
}
