<?php

namespace App\Applications\Venue\Requests;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Validation\Rule;

class VenueRequest extends ApiFormRequest
{
    public function authorize(): bool
    {
        // handled by middleware / policies
        return true;
    }

    public function rules(): array
    {
        $venueIdToIgnore = optional($this->route('venue'))->id ?? null;

        return [
            // Basic info
            'name'            => ['required', 'string', 'min:2', 'max:255'],
            'email'           => ['required', 'email:rfc,dns', 'min:3', 'max:255'],
            'address'         => ['required', 'string', 'min:2', 'max:255'],
            'bio'             => ['nullable', 'string', 'max:2000'],
            'city'            => ['required', 'string', 'min:2', 'max:255'],
            'country'         => ['required', 'string', 'size:2'], // e.g. "mk"

            // Contacts & coordinates
            'phone_number'    => ['nullable', 'string', 'max:30'],
            'lat'             => ['nullable', 'numeric', 'between:-90,90'],
            'lng'             => ['nullable', 'numeric', 'between:-180,180'],

            // Relations
            'user_id'         => ['required', 'integer', 'exists:users,id'],
            'collaborator_id' => ['required', 'integer', 'exists:users,id'],
            'venue_type_id'   => ['required', 'integer', 'exists:venue_types,id'],
        ];
    }

    // Removed withValidator(): no working_hours checks

    public function prepareForValidation(): void
    {
        // Normalize country to lowercase 2-letter code
        if ($this->has('country') && is_string($this->country)) {
            $this->merge(['country' => strtolower($this->country)]);
        }
    }

    public function attributes(): array
    {
        return [
            'name'             => 'venue name',
            'email'            => 'email',
            'address'          => 'address',
            'city'             => 'city',
            'country'          => 'country code',
            'phone_number'     => 'phone number',
            'lat'              => 'latitude',
            'lng'              => 'longitude',
            'user_id'          => 'owner user',
            'collaborator_id'  => 'collaborator',
            'venue_type_id'    => 'venue type',
        ];
    }

    public function messages(): array
    {
        return [];
    }
}
