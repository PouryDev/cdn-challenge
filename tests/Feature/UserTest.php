<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Check if user will be created successfully
     *
     * @return void
     */
    public function test_create_user(): void
    {
        $user = User::create([
            'phone_number' => fake()->phoneNumber,
        ]);
        $this->assertNotEmpty($user);
    }
}
