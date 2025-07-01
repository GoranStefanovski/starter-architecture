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
        $admin ??= User::where('email', 'admin@example.com')->first();

        $venueTypeId = VenueType::inRandomOrder()->value('id');
        $name = $this->faker->company;

        $city = $this->faker->randomElement(['Bitola', 'Skopje', 'Ohrid']);

        // Define lat/lng ranges and street examples for each city
        switch ($city) {
            case 'Skopje':
                $lat = $this->faker->latitude(41.990, 42.020);
                $lng = $this->faker->longitude(21.390, 21.470);
                $street = $this->faker->randomElement([
                    'Boulevard Partizanski Odredi', 'Macedonia Street', 'Nikola Karev', 'Debarca', 'Leninova'
                ]);
                break;

            case 'Ohrid':
                $lat = $this->faker->latitude(41.105, 41.125);
                $lng = $this->faker->longitude(20.785, 20.825);
                $street = $this->faker->randomElement([
                    'Kej Makedonija', 'Car Samoil', 'Turisticka', 'Partizanska', 'St. Naum Ohridski'
                ]);
                break;

            case 'Bitola':
            default:
                $lat = $this->faker->latitude(41.025, 41.060);
                $lng = $this->faker->longitude(21.300, 21.350);
                $street = $this->faker->randomElement([
                    'Shirok Sokak', 'Partizanska', 'Ruzveltova', 'Goce Delchev', 'Ivan Milutinovic'
                ]);
                break;
        }

        $address = $street . ' ' . $this->faker->buildingNumber . ', ' . $city . ', Macedonia';

        return [
            'name' => $name,
            'bio' => $this->faker->sentence(),
            'country' => 'mk',
            'city' => $city,
            'address' => $address,
            'lat' => $lat,
            'lng' => $lng,
            'email' => $this->faker->unique()->safeEmail(),
            'phone_number' => $this->faker->phoneNumber(),
            'slug' => Str::slug($name) . '-' . Str::random(4),
            'user_id' => $admin->id,
            'venue_type_id' => $venueTypeId,
        ];
    }

}
