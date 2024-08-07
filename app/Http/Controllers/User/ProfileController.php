<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Services\ProfileServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    protected ProfileServiceInterface $profileService;

    public function __construct(ProfileServiceInterface $profileService)
    {
        $this->profileService = $profileService;
    }

    public function show(): View
    {
        $user = $this->profileService->getUserProfile();
        return view('pages.profile.show', compact('user'));
    }

    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $this->profileService->updateUserProfile($request);

        return redirect()->route('pages.profile.show')
            ->with('status', 'Profile updated successfully');
    }

    public function editPassword(): View
    {
        return view('pages.profile.edit-password');
    }

    public function updatePassword(UpdatePasswordRequest $request): RedirectResponse
    {
        try {
            $this->profileService->updateUserPassword($request);

            return redirect()->route('pages.profile.show')
                ->with('status', 'Password updated successfully');
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        }
    }
}

