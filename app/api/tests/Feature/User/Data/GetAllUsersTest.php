<?php

namespace tests\Feature\User\Data;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Applications\User\Model\User;
use App\Constants\UserRoles;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetAllUsersTest extends TestCase
{
    use RefreshDatabase;
//
//    protected function setUp(): void
//    {
//        parent::setUp();
//
//        $this->seed(); // this runs DatabaseSeeder
//    }

    public function test_draw_users_response_data_structure()
    {
//        $this->seed(DatabaseSeeder::class);
        $admin = User::factory()->create();
        $admin->assignRole(UserRoles::ADMIN);


        $response = $this->actingAs($admin, 'web')->getJson('/api/user/draw');
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'first_name',
                        'last_name',
                        'email',
                        'avatar_url',
                        'avatar_thumbnail',
                        'role',
                        'is_disabled',
                        'permissions_array',
                    ]
                ],
                'pagination' => [
                    'total',
                    'count',
                    'currentPage',
                    'lastPage',
                    'limit',
                    'options' => [
                        'path',
                        'pageName',
                    ],
                    'dataLength'
                ]
            ]);

        $this->assertEquals(10, count($response->json('data')));
    }

    public function test_draw_users_pagination()
    {
//        $this->seed(DatabaseSeeder::class);
//        $admin = User::factory()->create();
//        $admin->assignRole(UserRoles::ADMIN);
//
//        $response = $this->actingAs($admin, 'web')->getJson('/api/user/draw?length=10&dir=asc&search=admin');
//
//
//        $response->assertStatus(200);
//
//        $users = $response->json('data');
//
//        $this->assertGreaterThan(0, count($users));
////        dd($users);
//
//        foreach ($users as $user) {
//            $combinedFields = strtolower(
//                $user['first_name'] . ' ' .
//                $user['last_name'] . ' ' .
//                $user['email']
//            );
//
//            $matchesText = str_contains($combinedFields, 'admin');
////            $matchesRole = $user['role'] === 1;
//
//            $this->assertTrue(
//                $matchesText, //|| $matchesRole,
//                "Expected user to match 'admin' in name/email or have role = 1. Got: {$combinedFields}, role: {$user['role']}"
//            );
//        }
    }
}
