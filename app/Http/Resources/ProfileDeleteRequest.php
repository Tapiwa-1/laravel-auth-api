<?php

namespace App\Http\Resources;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileDeleteRequest extends FormRequest
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    
     public function rules(): array
     {
         return [
            'password' => ['required', 'current_password'],  
         ];
     }
}
