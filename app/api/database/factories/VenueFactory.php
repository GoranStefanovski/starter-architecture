<?php

namespace Database\Factories;

use App\Applications\Common\Model\VenueType;
use App\Applications\User\Model\User;
use App\Applications\Venue\Model\Venue;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class VenueFactory extends Factory
{
    protected $model = Venue::class;


    public function definition(): array
    {
        static $admin;
        $admin ??= User::where('email', 'admin@example.com')->first();

        $streets = [
            'Shirok Sokak', 'Partizanska', 'Ruzveltova', 'Goce Delchev',
            'Ivan Milutinovic', 'Stevche Naumov', 'Jane Sandanski'
        ];
        $name = $this->faker->company;
        $venueTypeId = VenueType::inRandomOrder()->value('id');
        $email = $this->faker->unique()->safeEmail();

        return [
            'name' => $this->faker->sentence(3),
            'bio' => $this->faker->sentence(),
            'country' => 'North Macedonia',
            'city' => 'Bitola',
            'address' => $this->faker->randomElement($streets) . ' ' . $this->faker->buildingNumber . ', Bitola, Macedonia',
            'lng' => $this->faker->longitude(21.300, 21.370),
            'lat' => $this->faker->latitude(41.020, 41.060),
            'email' => $email,
            'phone_number' => $this->faker->phoneNumber(),
            'slug' => Str::slug($name) . '-' . Str::random(4),
            'user_id' => $admin->id, // or dynamically assign
            'venue_type_id' => $venueTypeId,
        ];
    }
}
