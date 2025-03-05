<?php

namespace App\Services;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class ProfileService
{
    public function createProfile(array $data): Profile
    {
        try {
            if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
                $imagePath = $data['image']->store('profiles', 'public');
                $data['image'] = $imagePath;
            }
            return Profile::create($data);
        } catch (Exception $e) {
            throw new Exception("Failed to create profile: " . $e->getMessage());
        }
    }

    public function updateProfile(Profile $profile, array $data): Profile
    {
        try {
            if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
                if ($profile->image) {
                    Storage::disk('public')->delete($profile->image);
                }
                $imagePath = $data['image']->store('profiles', 'public');
                $data['image'] = $imagePath;
            }
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

    public function getActiveProfiles(?User $user): Collection
    {
        try {
            if($user){
                return Profile::where('status', 'actif')
                                ->get();
            }
            return Profile::where('status', 'actif')
                            ->select('id', 'firstname', 'lastname')
                            ->get();
        } catch (Exception $e) {
            throw new Exception("Failed to retrieve profiles: " . $e->getMessage());
        }
    }

}
