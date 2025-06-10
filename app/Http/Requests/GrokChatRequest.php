<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GrokChatRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'question' => 'required|string|max:4000',
            'temperature' => 'nullable|numeric|min:0|max:2',
            'model' => 'nullable|string|in:grok-3-latest,grok-3-mini'
        ];
    }

    public function messages(): array
    {
        return [
            'question.required' => 'A pergunta é obrigatória.',
            'question.string' => 'A pergunta deve ser um texto.',
            'question.max' => 'A pergunta não pode ter mais de 4000 caracteres.',
            'temperature.numeric' => 'A temperatura deve ser um número.',
            'temperature.min' => 'A temperatura deve ser maior ou igual a 0.',
            'temperature.max' => 'A temperatura deve ser menor ou igual a 2.',
            'model.in' => 'O modelo deve ser um dos seguintes: grok-3-latest, grok-3-mini.'
        ];
    }
} 