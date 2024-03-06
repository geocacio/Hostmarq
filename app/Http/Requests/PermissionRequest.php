<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "permission_id" => "required|exists:permissions,id",
            "action" => "nullable|string|in:attach,detach",
            "clubs" => "nullable|array",
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */

    public function messages(): array
    {
        return [
            "permission_id.required" => "O campo permissão é obrigatório",
            "permission_id.exists" => "A permissão informada não existe",
            "action.string" => "O campo ação deve ser um texto",
            "clubs.array" => "O campo clubes deve ser um array",
        ];
    }
}
