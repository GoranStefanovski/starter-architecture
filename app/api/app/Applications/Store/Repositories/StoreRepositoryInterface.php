<?php

namespace App\Applications\Store\Repositories;

use App\Applications\Store\Model\Store;
use Illuminate\Database\Eloquent\Collection;
use App\Applications\Pagination\StarterPaginator;

interface StoreRepositoryInterface
{
    /**
     * Retrieve all stores.
     *
     * @return Collection|Store[]
     */
    public function all(): Collection;

    /**
     * Find a store by its ID.
     *
     * @param  int  $id
     * @return Store
     */
    public function findById(int $id): Store;

    /**
     * Create a new store.
     *
     * @param  array<string, mixed>  $data
     * @return Store
     */
    public function create(array $data): Store;

    /**
     * Update an existing store.
     *
     * @param  int $storeId
     * @param  array<string, mixed>  $data
     * @return Store
     */
    public function update(int $storeId, array $data): Store;

    /**
     * Delete an existing store.
     *
     * @param  Store  $store
     * @return bool|null
     */
    public function delete(Store $store): ?bool;

    /**
     * @param array $data
     * @return StarterPaginator
     */
    public function draw(array $data): StarterPaginator;

    /**
     * Find all visible stores that are currently live.
     * 
     * @return Collection
     */
    public function findLiveStores(): Collection;

    /**
     * Find all ancestors of a store by its ID.
     * 
     * @param int $id The store ID
     * @return Collection
     */
    public function findAncestors(int $id): Collection;

    /**
     * Find all descendants of a store by its ID.
     * 
     * @param int $id The store ID
     * @return Collection
     */
    public function findDescendants(int $id): Collection;

    /**
     * Check if a store with the given slug exists.
     * 
     * @param string $slug The slug to check
     * @return bool True if slug exists, false otherwise
     */
    public function doesSlugExist(string $slug): bool;
}
