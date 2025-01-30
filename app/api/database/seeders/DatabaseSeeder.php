<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Applications\User\Model\User;
use App\Constants\UserPermissions;
use App\Constants\UserRoles;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::create([
            'first_name' => 'Admin',
            'last_name' => 'Userot',
            'email' => 'admin@example.com',
            'password' => Hash::make('password')
        ]);

        $manager = User::create([
            'first_name' => 'Editor',
            'last_name' => 'Userot',
            'email' => 'manager@example.com',
            'password' => Hash::make('password')
        ]);

        $developer = User::create([
            'first_name' => 'Developer',
            'last_name' => 'Userot',
            'email' => 'developer@example.com',
            'password' => Hash::make('password')
        ]);

        $collaborator = User::create([
            'first_name' => 'Collaborator',
            'last_name' => 'Userot',
            'email' => 'collaborator@example.com',
            'password' => Hash::make('password')
        ]);

        // Create permissions
        Permission::create(['name' => UserPermissions::READ_USERS]);
        Permission::create(['name' => UserPermissions::WRITE_USERS]);
        Permission::create(['name' => UserPermissions::DELETE_USERS]);
        Permission::create(['name' => UserPermissions::READ_REQUESTS]);
        Permission::create(['name' => UserPermissions::WRITE_REQUESTS]);
        Permission::create(['name' => UserPermissions::DELETE_REQUESTS]);
        Permission::create(['name' => UserPermissions::DASHBOARD_VIEW]);

        // Create three roles and assign created permissions

        $roleAdmin = Role::create(['name' => UserRoles::ADMIN])->givePermissionTo(Permission::all());
        
        $roleManager = Role::create(['name' => UserRoles::MANAGER])->givePermissionTo([UserPermissions::DASHBOARD_VIEW, UserPermissions::READ_USERS, UserPermissions::READ_REQUESTS, UserPermissions::WRITE_REQUESTS]);
        
        $roleDeveloper = Role::create(['name' => UserRoles::DEVELOPER])->givePermissionTo([UserPermissions::DASHBOARD_VIEW, UserPermissions::READ_REQUESTS, UserPermissions::WRITE_REQUESTS, UserPermissions::DELETE_REQUESTS]);
        
        $roleCollaborator = Role::create(['name' => UserRoles::COLLABORATOR])->givePermissionTo([UserPermissions::DASHBOARD_VIEW, UserPermissions::READ_USERS, UserPermissions::READ_REQUESTS]);

        $roles = [$roleAdmin->id, $roleManager->id, $roleDeveloper->id, $roleCollaborator->id];

        // Adding permissions via a role
        $admin->assignRole(UserRoles::ADMIN);
        $manager->assignRole(UserRoles::MANAGER);
        $developer->assignRole(UserRoles::DEVELOPER);
        $collaborator->assignRole(UserRoles::COLLABORATOR);

        $faker = Faker::create();

        // Common password for all users, hashed
        $password = Hash::make('password');

        for ($i = 0; $i < 100; $i++) {
            // Create a new user with random data
            $user = User::create([
                'first_name' => $faker->name,
                'last_name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => $password,
                // Other fields like 'first_name', 'last_name', etc., can be added here
            ]);

            // Assign a random role to the user
            $user->roles()->attach($faker->randomElement($roles));
        }

        // Leave Types
        $leaveTypes = [
            ['name' => 'Sick (unpaid)', 'slug' => Str::slug('Sick unpaid'), 'is_paid' => false],
            ['name' => 'Sick (paid)', 'slug' => Str::slug('Sick paid'), 'is_paid' => true],
            ['name' => 'Vacation Day (paid)', 'slug' => Str::slug('Vacation Day paid'), 'is_paid' => true],
            ['name' => 'Vacation Day (unpaid)', 'slug' => Str::slug('Vacation Day unpaid'), 'is_paid' => false],
        ];

        DB::table('leave_types')->insert($leaveTypes);
    }
}
