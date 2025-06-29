<?php

namespace tests\Feature\User\Authorization;

use App\Applications\User\Model\User;
use App\Constants\UserRoles;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserAuthorizationTest extends TestCase
{
    use DatabaseTransactions;

    public function test_admin_can_list_users()
    {
        $admin = User::factory()->admin()->create();
        $admin->assignRole(UserRoles::ADMIN);

        User::factory()->count(9)->create()->each(function ($user) {
            $user->assignRole(User::PUBLIC);
        });
        $response = $this->actingAs($admin, 'sanctum')->getJson('/api/user/all');

        $response->assertStatus(200)
            ->assertJsonCount(6, 'data');
    }

    public function test_collaborator_cannot_list_users_if_allowed()
    {
        $user = User::factory()->collaborator()->create();

        $response = $this->actingAs($user, 'sanctum')->getJson('/api/user/all');

        $response->assertForbidden();
    }

    public function test_organization_cannot_list_users()
    {
        $user = User::factory()->collaborator()->create();

        $response = $this->actingAs($user, 'sanctum')->getJson('/api/user/all');

        $response->assertForbidden();
    }

    public function test_public_user_cannot_list_users()
    {
        $user = User::factory()->public()->create();

        $response = $this->actingAs($user, 'sanctum')->getJson('/api/user/all');

        $response->assertForbidden();
    }

}
