<?php
namespace App\Services;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileService implements ProfileServiceInterface
{
	public function getUserProfile(): User
	{
		$authUserId = Auth::id();

		$user = User::findOrFail($authUserId);

		return $user;
	}

	public function updateUserProfile(Request $request): bool
	{
		$user = $this->getUserProfile();
		return $user->update($request->validated());
	}

	public function updateUserPassword(Request $request): bool
	{
		$user = $this->getUserProfile();
		if (!Hash::check($request->current_password, $user->password)) {
			return false;
		}

		return $user->update(['password' => Hash::make($request->password)]);
	}
}
