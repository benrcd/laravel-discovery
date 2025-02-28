<?php

namespace App\Services;

use App\Models\Profile;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use Illuminate\Database\Eloquent\Collection;

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

    public function deleteProfile(Profile $profile): bool
    {
        try {
            return $profile->delete();
        } catch (Exception $e) {
            throw new Exception("Failed to delete profile: " . $e->getMessage());
        }

    }

    public function getActiveProfiles(): Collection
    {
        try {
                return Profile::where('status', 'actif')
                ->select('id', 'firstname', 'lastname')
                ->get();
        } catch (Exception $e) {
            throw new Exception("Failed to retrieve profiles: " . $e->getMessage());
        }
    }

    public function getActiveProfilesAdmin(): Collection
    {
        try {
                return Profile::where('status', 'actif')
                ->get();
        } catch (Exception $e) {
            throw new Exception("Failed to retrieve profiles: " . $e->getMessage());
        }
    }

}
