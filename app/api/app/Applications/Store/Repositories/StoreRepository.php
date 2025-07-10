<?php

namespace App\Applications\Store\Repositories;

use App\Applications\Store\Model\Store;
use Illuminate\Database\Eloquent\Collection;
use App\Applications\Pagination\StarterPaginator;
use App\Applications\User\Model\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\AuthorizationException;

/**
 * @property Store $store
 */
class StoreRepository implements StoreRepositoryInterface
{
    private const COLUMNS_MAP = [
        'name' => 'stores.name',
        'domain' => 'stores.domain',
        'website' => 'stores.website',
        'phone' => 'stores.phone',
        'status' => 'stores.is_active'
    ];

    public function __construct(
        Store $store
    ) {
        $this->store = $store;
    }
    /**
     * Retrieve all stores.
     *
     * @return \Illuminate\Database\Eloquent\Collection|Store[]
     */
    public function all(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->store::all();
    }

    /**
     * Find a store by its ID, including its related content.
     *
     * @param  int  $id
     * @return Store
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findById(int $id): Store
    {
        // Eager-load the content relationship
        return $this->store::findOrFail($id);
    }

    /**
     * Create a new store.
     *
     * @param  array<string, mixed>  $data
     * @return Store
     */
    public function create(array $data): Store
    {
        return $this->store::create($data);
    }

    /**
     * Update an existing store.
     *
     * @param  int $storeId
     * @param  array<string, mixed>  $data
     * @return Store
     */
    public function update(int $storeId, array $data): Store
    {
        $store = $this->store->findOrFail($storeId);

        $user = Auth::user();

        // 🔥 Check if user is admin or owner
        if (!$user->hasRole(User::ADMIN) && $store->user_id !== $user->id) {
            throw new AuthorizationException('You are not authorized to update this store.');
        }

        $store->update($data);

        return $store;
    }
        /**
     * Delete an existing store.
     *
     * @param  Store  $store
     * @return bool|null
     */
    public function delete(Store $store): ?bool
    {
        return $store->delete();
    }

    public function draw($data): StarterPaginator
    {
        //        $paginatedUsers = $this->prepareDatatableQuery($data, [User::ADMIN, User::EDITOR, User::COLLABORATOR]);

        $query = $this->store->query();
        $user = Auth::user();
        if (!$user->hasRole(User::ADMIN)) {
            $query->where('user_id', $user->id);
        }
        // $query->whereIn('roles.name', $roles);

        if (array_key_exists($data['column'], self::COLUMNS_MAP)) {
            $query->orderBy(self::COLUMNS_MAP[$data['column']], $data['dir']);
        }

        $search = $data['search'];
        if ($search) {
            $query->where(function ($subquery) use ($search) {
                $subquery->where('stores.name', 'like', '%' . $search . '%');
                $subquery->orWhere('stores.website', 'like', '%' . $search . '%');
                $subquery->orWhere('stores.domain', 'like', '%' . $search . '%');
            });
        }

        $query->whereNull('deleted_at');

        return $query->paginate($data['length']);
    }

    public function findWithAncestors(int $id): Store
    {
        return $this->store::with(['parent'])
            ->with(['treepath' => function ($query) use ($id) {
                $query->where('descendant', $id);
            }])
            ->findOrFail($id);
    }

    /**
     * Find all ancestors of a store by its ID.
     *
     * @param  int  $id
     * @return Collection
     */
    public function findAncestors(int $id): Collection
    {
        return $this->store::whereIn('id', function ($query) use ($id) {
            $query->select('ancestor')
                ->from('store_treepath')
                ->where('descendant', $id);
        })->get();
    }

    public function findDescendants(int $id): Collection
    {
        return $this->store::whereIn('id', function ($query) use ($id) {
            $query->select('descendant')
                ->from('store_treepath')
                ->where('ancestor', $id);
        })->get();
    }

    /**
     * Find all visible stores that are currently live.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findLiveStores(): Collection
    {
        return $this->store->where('visible', true)
            ->where('livedate', '<=', now())
            ->where(function ($query) {
                $query->whereNull('enddate')
                    ->orWhere('enddate', '>=', now());
            })
            ->get();
    }

    public function doesSlugExist(string $slug): bool
    {
        return $this->store::where('slug', $slug)->exists();
    }
}
