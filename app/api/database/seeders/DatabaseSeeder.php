<?php

namespace Database\Seeders;

use App\Applications\User\Model\User;
use App\Constants\UserPermissions;
use App\Constants\UserRoles;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Users
        $admin = User::create([
            'first_name' => 'Admin',
            'last_name' => 'Userot',
            'email' => 'admin@example.com',
            'password' => Hash::make('password')
        ]);

        $manager = User::create([
            'first_name' => 'Manager',
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

        // Create Permissions
        $permissions = [
            UserPermissions::READ_USERS,
            UserPermissions::WRITE_USERS,
            UserPermissions::DELETE_USERS,
            UserPermissions::READ_REQUESTS,
            UserPermissions::APPROVE_REQUESTS,
            UserPermissions::WRITE_REQUESTS,
            UserPermissions::DELETE_REQUESTS,
            UserPermissions::DASHBOARD_VIEW,
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create Roles and Assign Permissions
        $roleAdmin = Role::create(['name' => UserRoles::ADMIN])
            ->givePermissionTo(Permission::all());

        $roleManager = Role::create(['name' => UserRoles::MANAGER])
            ->givePermissionTo([
                UserPermissions::DASHBOARD_VIEW,
                UserPermissions::READ_USERS,
                UserPermissions::READ_REQUESTS,
                UserPermissions::WRITE_REQUESTS,
                UserPermissions::APPROVE_REQUESTS,
            ]);

        $roleDeveloper = Role::create(['name' => UserRoles::DEVELOPER])
            ->givePermissionTo([
                UserPermissions::DASHBOARD_VIEW,
                UserPermissions::READ_REQUESTS,
                UserPermissions::WRITE_REQUESTS,
                UserPermissions::DELETE_REQUESTS,
            ]);

        $roleCollaborator = Role::create(['name' => UserRoles::COLLABORATOR])
            ->givePermissionTo([
                UserPermissions::DASHBOARD_VIEW,
                UserPermissions::READ_USERS,
                UserPermissions::READ_REQUESTS,
            ]);

        // Assign Roles to Users
        $admin->assignRole(UserRoles::ADMIN);
        $manager->assignRole(UserRoles::MANAGER);
        $developer->assignRole(UserRoles::DEVELOPER);
        $collaborator->assignRole(UserRoles::COLLABORATOR);

        // Seed Leave Types
        $leaveTypes = [
            ['name' => 'Sick (unpaid)', 'slug' => Str::slug('Sick unpaid'), 'is_paid' => false],
            ['name' => 'Sick (paid)', 'slug' => Str::slug('Sick paid'), 'is_paid' => true],
            ['name' => 'Vacation Day (paid)', 'slug' => Str::slug('Vacation Day paid'), 'is_paid' => true],
            ['name' => 'Vacation Day (unpaid)', 'slug' => Str::slug('Vacation Day unpaid'), 'is_paid' => false],
        ];

        DB::table('leave_types')->insert($leaveTypes);
    }
}
