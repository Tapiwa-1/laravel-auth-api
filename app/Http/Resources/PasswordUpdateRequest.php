<?php

namespace App\Http\Resources;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class PasswordUpdateRequest extends FormRequest
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
     {
         return [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
         ];
     }
}
