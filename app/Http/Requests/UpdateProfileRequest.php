<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function rules()
    {
        $userId = auth()->id();

        return [
            'name' => ['required', 'string', 'max:255', 'unique:users,name,' . $userId],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $userId],
        ];
    }
}
