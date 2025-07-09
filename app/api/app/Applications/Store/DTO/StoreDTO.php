<?php

namespace App\Applications\Store\DTO;

use App\Applications\Store\Model\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class StoreDTO
{
    public int $id;
    public string $name;
    public string $slug;
    public string $domain;
    public ?string $address;
    public ?string $phone;
    public ?string $email;
    public ?string $website;
    public ?string $description;

    public function __construct(
        int $id,
        string $name,
        string $slug,
        string $domain,
        ?string $address = null,
        ?string $phone = null,
        ?string $email = null,
        ?string $website = null,
        ?string $description = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->slug = $slug;
        $this->domain = $domain;
        $this->address = $address;
        $this->phone = $phone;
        $this->email = $email;
        $this->website = $website;
        $this->description = $description;
    }

    /**
     * Validate store data.
     *
     * @param array $data
     * @throws ValidationException
     */
    protected static function validate(array $data): void
    {
        $rules = [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:stores,slug,' . ($data['id'] ?? '0'),
            'domain' => 'required|string|max:255|unique:stores,domain,' . ($data['id'] ?? '0'),
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'description' => 'nullable|string',
        ];

        Validator::make($data, $rules)->validate();
    }

    /**
     * Create StoreDTO from request data.
     *
     * @param Request $request
     * @return static
     * @throws ValidationException
     */
    public static function fromRequest(Request $request): self
    {
        $data = $request->all();
        self::validate($data);

        return new self(
            id: $data['id'] ?? 0,
            name: $data['name'],
            slug: $data['slug'],
            domain: $data['domain'],
            address: $data['address'] ?? null,
            phone: $data['phone'] ?? null,
            email: $data['email'] ?? null,
            website: $data['website'] ?? null,
            description: $data['description'] ?? null
        );
    }

    /**
     * Create StoreDTO from an existing Store model.
     *
     * @param Store $store
     * @return static
     */
    public static function fromModel(Store $store): self
    {
        return new self(
            id: $store->id,
            name: $store->name,
            slug: $store->slug,
            domain: $store->domain,
            address: $store->address,
            phone: $store->phone,
            email: $store->email,
            website: $store->website,
            description: $store->description
        );
    }

    /**
     * Convert the DTO to an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'domain' => $this->domain,
            'address' => $this->address,
            'phone' => $this->phone,
            'email' => $this->email,
            'website' => $this->website,
            'description' => $this->description,
        ];
    }

    /**
     * Convert a collection of Store models to an array of DTOs.
     *
     * @param iterable $stores
     * @return array
     */
    public static function fromCollection(iterable $stores): array
    {
        return array_map(function (Store $store) {
            return self::fromModel($store)->toArray();
        }, $stores->all());
    }
}
