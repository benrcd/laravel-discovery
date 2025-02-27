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
}
