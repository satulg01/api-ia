<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OpenAIChatRequest extends FormRequest
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
            'model' => 'nullable|string|in:gpt-3.5-turbo,gpt-4,gpt-4-turbo,gpt-4o,gpt-4o-mini',
            'max_tokens' => 'nullable|integer|min:1|max:4096',
            'top_p' => 'nullable|numeric|min:0|max:1',
            'frequency_penalty' => 'nullable|numeric|min:-2|max:2',
            'presence_penalty' => 'nullable|numeric|min:-2|max:2'
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
            'model.in' => 'O modelo deve ser um dos seguintes: gpt-3.5-turbo, gpt-4, gpt-4-turbo, gpt-4o, gpt-4o-mini.',
            'max_tokens.integer' => 'O máximo de tokens deve ser um número inteiro.',
            'max_tokens.min' => 'O máximo de tokens deve ser maior que 0.',
            'max_tokens.max' => 'O máximo de tokens deve ser menor ou igual a 4096.',
            'top_p.numeric' => 'O top_p deve ser um número.',
            'top_p.min' => 'O top_p deve ser maior ou igual a 0.',
            'top_p.max' => 'O top_p deve ser menor ou igual a 1.',
            'frequency_penalty.numeric' => 'O frequency_penalty deve ser um número.',
            'frequency_penalty.min' => 'O frequency_penalty deve ser maior ou igual a -2.',
            'frequency_penalty.max' => 'O frequency_penalty deve ser menor ou igual a 2.',
            'presence_penalty.numeric' => 'O presence_penalty deve ser um número.',
            'presence_penalty.min' => 'O presence_penalty deve ser maior ou igual a -2.',
            'presence_penalty.max' => 'O presence_penalty deve ser menor ou igual a 2.'
        ];
    }
} 