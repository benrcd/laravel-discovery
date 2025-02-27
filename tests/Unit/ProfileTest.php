<?php

namespace Tests\Feature;

use App\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_basic_test(): void
    {
        $this->assertTrue(true);
    }

    public function test_creates_a_profile_with_valid_data()
    {
        $profileData = Profile::factory()->make()->toArray();

        $response = $this->postJson('/api/profiles', $profileData);

        $response->assertStatus(201)
            ->assertJson([
                'firstname' => $profileData['firstname'],
                'lastname' => $profileData['lastname'],
                'status' => $profileData['status'],
            ]);

        $this->assertDatabaseHas('profiles', ['firstname' => $profileData['firstname']]);
    }

    public function test_fails_when_required_fields_are_missing()
    {
        $response = $this->postJson('/api/profiles', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['firstname', 'lastname', 'status']);
    }

    public function test_fails_when_status_is_invalid()
    {
        $profileData = Profile::factory()->make()->toArray();
        $profileData['status'] = 'invalid_status';

        $response = $this->postJson('/api/profiles', $profileData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['status']);
    }

}
