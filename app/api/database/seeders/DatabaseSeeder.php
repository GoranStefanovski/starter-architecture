<?php

namespace Database\Seeders;

use App\Applications\Event\Model\Event;
use App\Applications\User\Model\User;
use App\Applications\Venue\Model\Venue;
use App\Constants\RolePermissionsMap;
use App\Constants\UserRoles;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    const NUMBER_OF_FAKE_USERS = 30;
    const NUMBER_OF_VENUES = 15;
    const NUMBER_OF_EVENTS = 20;

    const STATIC_USERS = [
        [
            "email" => "admin@example.com",
            "first_name" => "Admin",
            "role" => UserRoles::ADMIN,
        ],
        [
            "email" => "organization@example.com",
            "first_name" => "Organization",
            "role" => UserRoles::ORGANIZATION,
        ],
        [
            "email" => "collaborator@example.com",
            "first_name" => "Collaborator",
            "role" => UserRoles::COLLABORATOR,
        ],
        [
            "email" => "public@example.com",
            "first_name" => "Public",
            "role" => UserRoles::PUBLIC,
        ],
    ];

    public function run(): void
    {
        // Create all permissions
        collect(RolePermissionsMap::MAP)->flatten()->unique()->each(function ($permission) {
            Permission::firstOrCreate(['name' => $permission]);
        });

        // Create roles and assign their mapped permissions
        foreach (RolePermissionsMap::MAP as $role => $permissions) {
            Role::firstOrCreate(['name' => $role])
                ->syncPermissions($permissions);
        }

        // Create static users with defined roles
        foreach (self::STATIC_USERS as $static) {
            $user = User::factory()->create([
                'first_name' => $static['first_name'],
                'email' => $static['email'],
                'password' => Hash::make('password'),
                'role' => $static['role'],
            ]);
            $user->assignRole($static['role']);
        }

        $rolesPool = array_merge(
            array_fill(0, 60, UserRoles::PUBLIC),        // 60% public
            array_fill(0, 20, UserRoles::ARTIST),        // 20% artist
            array_fill(0, 15, UserRoles::ORGANIZATION),  // 15% organization
            array_fill(0, 5, UserRoles::COLLABORATOR)    // 5% collaborator
            // Exclude UserRoles::ADMIN
        );

        // Create N random users
        User::factory(self::NUMBER_OF_FAKE_USERS)->create()->each(function ($user) use ($rolesPool) {
            $role = $rolesPool[array_rand($rolesPool)];
            $user->update([
                'role' => $role,
                'artist_tag' => $role === UserRoles::ARTIST ? fake()->unique()->userName() : null,
            ]);
            $user->assignRole($role);
        });

        Venue::factory()->count(self::NUMBER_OF_VENUES)->create();
        Event::factory()->count(self::NUMBER_OF_EVENTS)->create();
    }
}
