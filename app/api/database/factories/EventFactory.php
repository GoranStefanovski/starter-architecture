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
        static $admin;
        $admin ??= User::where('email', 'admin@example.com')->first();

        $startHour = $this->faker->numberBetween(20, 23); // between 8 PM and 11 PM
        $startMinute = $this->faker->randomElement([0, 15, 30, 45]); // quarter intervals

        $start = $this->faker->dateTimeBetween('+1 day', '+10 days')->setTime($startHour, $startMinute);

        $durationMinutes = $this->faker->numberBetween(120, 300); // 2–5 hours
        $end = (clone $start)->modify("+{$durationMinutes} minutes");

        // Randomly decide: held in venue or outdoor
        $heldInVenue = $this->faker->boolean(70); // 70% chance it's held inside a venue

        if ($heldInVenue && $venue = Venue::inRandomOrder()->first()) {
            // Use venue's location
            $address = $venue->address;
            $lat = $venue->lat;
            $lng = $venue->lng;
            $venueId = $venue->id;
        } else {
            // Random outdoor event
            $address = $this->faker->optional()->address(); // Sometimes address, sometimes null
            $lat = $this->faker->latitude(41.020, 41.060);
            $lng = $this->faker->longitude(21.300, 21.370);
            $venueId = null;
        }

        return [
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'country' => 'North Macedonia',
            'city' => 'Bitola',
            'address' => $address,
            'lat' => $lat,
            'lng' => $lng,
            'event_start' => $start,
            'event_end' => $end,
            'slug' => Str::slug($this->faker->unique()->sentence(3)),
            'user_id' => $admin->id, // override in seeder or factory call
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
