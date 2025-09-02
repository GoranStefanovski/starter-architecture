<?php

namespace App\Applications\Event\Requests;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Validation\Rule;

class EventRequest extends ApiFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isCreate = $this->isMethod('post');   // true = create, false = update

        return [
            // Core
            'name'        => [$isCreate ? 'required' : 'sometimes', 'string', 'min:2', 'max:255'],
            'description' => ['nullable', 'string'],

            // Dates
            'event_start' => [$isCreate ? 'required' : 'sometimes', 'before:event_end'],
            'event_end'   => [$isCreate ? 'required' : 'sometimes', 'after:event_start'],

            // User / Venue
            'user_id'     => [$isCreate ? 'required' : 'sometimes', 'integer', 'exists:users,id'],
            'venue_id'    => ['nullable', 'integer', 'exists:venues,id'],

            // Location (required if no venue_id, nullable if venue_id present)
            'address'     => ['nullable', 'required_without:venue_id', 'string', 'min:2', 'max:255'],
            'city'        => ['nullable', 'required_without:venue_id', 'string', 'min:2', 'max:255'],
            'country'     => ['nullable', 'required_without:venue_id', 'string', 'size:2'],
            'lat'         => ['nullable', 'required_without:venue_id', 'numeric', 'between:-90,90'],
            'lng'         => ['nullable', 'required_without:venue_id', 'numeric', 'between:-180,180'],

            // Flags
            'is_active'   => ['sometimes', 'boolean'],
            'is_boosted'  => ['sometimes', 'boolean'],

            // Genres
            'genreIds'   => ['required', 'array', 'min:1'],

            // Tickets
            'tickets'                => ['nullable', 'array'],
            'tickets.*.price'        => ['required_with:tickets', 'numeric', 'min:0'],
            'tickets.*.quantity'     => ['required_with:tickets', 'integer', 'min:0'],
            'tickets.*.sale_start'   => ['nullable', 'date'],
            'tickets.*.sale_end'     => ['nullable', 'date', 'after_or_equal:tickets.*.sale_start', 'before_or_equal:event_end'],
        ];
    }

    public function prepareForValidation(): void
    {
        if (is_string($this->country)) {
            $this->merge(['country' => strtolower($this->country)]);
        }
    }

    public function attributes(): array
    {
        return [
            'name'                 => 'event name',
            'event_start'          => 'event start',
            'event_end'            => 'event end',
            'venue_id'             => 'venue',
            'address'              => 'address',
            'city'                 => 'city',
            'country'              => 'country code',
            'lat'                  => 'latitude',
            'lng'                  => 'longitude',
            'genreIds'             => 'genres',
            'tickets'              => 'tickets',
            'tickets.*.price'      => 'ticket price',
            'tickets.*.quantity'   => 'ticket quantity',
            'tickets.*.sale_start' => 'ticket sale start',
            'tickets.*.sale_end'   => 'ticket sale end',
        ];
    }

    public function messages(): array
    {
        return [
            'address.required_without' => 'The address field is required when no venue is selected.',
            'city.required_without'    => 'The city field is required when no venue is selected.',
            'country.required_without' => 'The country code is required when no venue is selected.',
            'lat.required_without'     => 'Latitude is required when no venue is selected.',
            'lng.required_without'     => 'Longitude is required when no venue is selected.',
            'event_start.before'       => 'Event start must be before event end.',
            'event_end.after'          => 'Event end must be after event start.',
        ];
    }
}
