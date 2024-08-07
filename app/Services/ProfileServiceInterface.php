<?php
namespace App\Services;

use Illuminate\Http\Request;
use App\Models\User;

interface ProfileServiceInterface
{
	public function getUserProfile(): User;
	public function updateUserProfile(Request $request): bool;
	public function updateUserPassword(Request $request): bool;
}
