<?php

namespace App\Applications\User\Requests;

use App\Http\Requests\ApiFormRequest;

class MyProfileRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name'         => 'required|string|min:2|max:255',
            'last_name'          => 'required|string|min:2|max:255',
            'phone_number'       => 'nullable|string|max:25',
            'username'           => 'nullable|string|max:100',
            'artist_tag'         => 'nullable|string|max:100',
            'bio'                => 'nullable|string|max:1000',
            'city_from'          => 'nullable|string|max:200',
            'country_from'       => 'nullable|string|max:200',
            'instagram_link'     => 'nullable|url|max:255',
            'instagram_video'    => 'nullable|url|max:255',
            'facebook_link'      => 'nullable|url|max:255',
            'facebook_video'     => 'nullable|url|max:255',
            'soundcloud_link'    => 'nullable|url|max:255',
            'soundcloud_track'   => 'nullable|url|max:255',
            'spotify_link'       => 'nullable|url|max:255',
            'spotify_track'      => 'nullable|url|max:255',
            'youtube_link'       => 'nullable|url|max:255',
            'youtube_video'      => 'nullable|url|max:255',
            'contact_phone'      => 'nullable|string|max:25',
            'contact_email'      => 'nullable|email|max:150',
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'users.first_name.required',
            'first_name.max'      => 'users.first_name.max',
            'first_name.min'      => 'users.first_name.min',
            'last_name.required'  => 'users.last_name.required',
            'last_name.max'       => 'users.last_name.max',
            'last_name.min'       => 'users.last_name.min',
            'contact_email.email' => 'users.contact_email.email',
        ];
    }
}
