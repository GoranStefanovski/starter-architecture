<?php

namespace Database\Factories;

use App\Applications\User\Model\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        $email = $this->faker->unique()->safeEmail();
        $password = explode('@', $email)[0]; // use part before @

        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'artist_tag' => null, // default null
            'bio' => $this->faker->optional()->paragraph(),
            'city_from' => 'Bitola',
            'country_from' => 'North Macedonia',
            'email' => $email,
            'phone_number' => $this->faker->phoneNumber(),
            'password' => bcrypt($password),
            'role' => User::PUBLIC,
            'is_disabled' => false,
            'remember_token' => Str::random(10),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
