<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Profile;
use Illuminate\Http\JsonResponse;
use App\Services\ProfileService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    private ProfileService $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function store(StoreProfileRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        
        $newProfile = $this->profileService->createProfile($validatedData);

        return response()->json([
            'newProfile' => $newProfile
        ], 201);
    }

    public function update(UpdateProfileRequest $request, Profile $profile): JsonResponse
    {
        $updatedProfile = $this->profileService->updateProfile($profile, $request->validated());

        return response()->json([
            'updatedProfile' => $updatedProfile
        ], 200);
    }

    public function destroy(Profile $profile): JsonResponse
    {
        $this->profileService->deleteProfile($profile);

        return response()->json([
            'message' => 'The profile has been successfully deleted'
        ]);
    }

    public function getActiveProfiles(): JsonResponse
    {
        $user = Auth::guard('sanctum')->user();

        if ($user) {
            $profiles = $this->profileService->getActiveProfilesAdmin();
            return response()->json($profiles);
        }
        $profiles = $this->profileService->getActiveProfiles();
        return response()->json($profiles);
    }
}
