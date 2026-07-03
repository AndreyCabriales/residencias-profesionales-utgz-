<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDocumentoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Solo los alumnos pueden subir documentos usando este request
        return auth()->user()->hasRole('alumno');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'documento' => 'required|file|mimes:pdf|max:5120', // Máximo 5MB (5120 KB)
        ];
    }

    public function messages(): array
    {
        return [
            'documento.required' => 'Debe seleccionar un archivo para subir.',
            'documento.file' => 'El archivo subido no es válido.',
            'documento.mimes' => 'El documento debe estar en formato PDF.',
            'documento.max' => 'El tamaño del PDF no debe exceder los 5MB.',
        ];
    }
}
