<?php

namespace Database\Factories;

use App\Applications\Common\Model\MusicGenre;
use App\Applications\User\Model\User;
use App\Applications\Venue\Model\Venue;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Applications\Event\Model\Event;

class EventFactory extends Factory
{
    protected $model = Event::class;


    public function definition(): array
    {
        $admin ??= User::where('email', 'admin@example.com')->first();

        $startHour = $this->faker->numberBetween(20, 23); // between 8 PM and 11 PM
        $startMinute = $this->faker->randomElement([0, 15, 30, 45]);

        $start = $this->faker->dateTimeBetween('+1 day', '+10 days')->setTime($startHour, $startMinute);
        $durationMinutes = $this->faker->numberBetween(120, 300); // 2–5 hours
        $end = (clone $start)->modify("+{$durationMinutes} minutes");

        $city = $this->faker->randomElement(['Bitola', 'Skopje', 'Ohrid']);

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

        // 🎲 70% chance to use a venue in the same city
        $venue = null;
        $venueId = null;
        if ($this->faker->boolean(70)) {
            $venue = Venue::where('city', $city)->inRandomOrder()->first();
        }
        $address = $street . ' ' . $this->faker->buildingNumber . ', ' . $city . ', Macedonia';
        if ($venue) {
            $address = $venue->address;
            $lat = $venue->lat;
            $lng = $venue->lng;
            $venueId = $venue->id;
        }

        return [
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'country' => 'mk',
            'city' => $city,
            'address' => $address,
            'lat' => $lat,
            'lng' => $lng,
            'event_start' => $start,
            'event_end' => $end,
            'slug' => Str::slug($this->faker->unique()->sentence(3)),
            'user_id' => $admin->id,
            'venue_id' => $venueId,
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Event $event) {
            // Attach 0–3 random genres
            $genres = MusicGenre::inRandomOrder()->limit(rand(0, 3))->pluck('id');
            $event->musicGenres()->attach($genres);
        });
    }
}
