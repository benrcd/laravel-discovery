<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfileRequest;
use App\Models\Profile;
use Illuminate\Http\JsonResponse;
use App\Services\ProfileService;

class ProfileController extends Controller
{
    private ProfileService $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function index(): JsonResponse
    {
        $profiles = (Profile::query()->get());
        return response()->json($profiles);
    }

    public function store(StoreProfileRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        
        $newProfile = $this->profileService->createProfile($validatedData);

        return response()->json([
            'id' => $newProfile->id,
            'firstname' => $newProfile->firstname,
            'lastname' => $newProfile->lastname,
            'status' => $newProfile->status,
        ], 201);
    }

}
