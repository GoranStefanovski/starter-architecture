<?php

namespace App\Applications\Store\Services;

use App\Applications\Store\DTO\StoreDTO;
use App\Applications\Store\Model\Store;
use Illuminate\Database\Eloquent\Collection;

interface StoreServiceInterface
{
    /**
     * Retrieve all stores.
     *
     * @return Collection|StoreDTO[]
     */
    public function getAllStores(): Collection;

    /**
     * Retrieve a single store by its ID.
     *
     * @param  int  $id
     * @return StoreDTO
     */
    public function getStoreById(int $id): StoreDTO;

    /**
     * Create a new store.
     *
     * @param  array<string, mixed>  $data
     * @return Store
     */
    public function createStore(array $data): Store;

    /**
     * Update an existing store.
     *
     * @param  int $storeId
     * @param  array<string, mixed>  $data
     * @return Store
     */
    public function updateStore(int $storeId, array $data): Store;

    /**
     * Delete a store.
     *
     * @param  Store  $store
     * @return bool|null
     */
    public function deleteStore(Store $store): ?bool;
}
