<?php

namespace App\Services;

use App\Models\Profile;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
class ProfileService
{
    public function createProfile(array $data): Profile
    {
        try {
            return Profile::create($data);
        } catch (Exception $e) {
            throw new Exception("Failed to create profile: " . $e->getMessage());
        }
    }

    public function updateProfile(Profile $profile, array $data): Profile
    {
        try {
            $profile->update($data);
            return $profile;
        } catch (Exception $e) {
            throw new Exception("Failed to update profile: " . $e->getMessage());
        }
    }
}
