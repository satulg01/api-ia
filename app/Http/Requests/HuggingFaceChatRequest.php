<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HuggingFaceChatRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'question' => 'required|string|max:4000',
            'model' => 'nullable|string|max:200',
            'max_length' => 'nullable|integer|min:10|max:1000',
            'temperature' => 'nullable|numeric|min:0|max:2',
            'do_sample' => 'nullable|boolean',
            'top_p' => 'nullable|numeric|min:0|max:1',
            'top_k' => 'nullable|integer|min:1|max:100',
            'repetition_penalty' => 'nullable|numeric|min:0.1|max:2',
            'max_time' => 'nullable|integer|min:1|max:120'
        ];
    }

    public function messages(): array
    {
        return [
            'question.required' => 'A pergunta é obrigatória.',
            'question.string' => 'A pergunta deve ser um texto.',
            'question.max' => 'A pergunta não pode ter mais de 4000 caracteres.',
            'model.string' => 'O modelo deve ser um texto.',
            'model.max' => 'O nome do modelo não pode ter mais de 200 caracteres.',
            'max_length.integer' => 'O máximo de tokens deve ser um número inteiro.',
            'max_length.min' => 'O máximo de tokens deve ser maior que 10.',
            'max_length.max' => 'O máximo de tokens deve ser menor ou igual a 1000.',
            'temperature.numeric' => 'A temperatura deve ser um número.',
            'temperature.min' => 'A temperatura deve ser maior ou igual a 0.',
            'temperature.max' => 'A temperatura deve ser menor ou igual a 2.',
            'do_sample.boolean' => 'O do_sample deve ser verdadeiro ou falso.',
            'top_p.numeric' => 'O top_p deve ser um número.',
            'top_p.min' => 'O top_p deve ser maior ou igual a 0.',
            'top_p.max' => 'O top_p deve ser menor ou igual a 1.',
            'top_k.integer' => 'O top_k deve ser um número inteiro.',
            'top_k.min' => 'O top_k deve ser maior que 0.',
            'top_k.max' => 'O top_k deve ser menor ou igual a 100.',
            'repetition_penalty.numeric' => 'O repetition_penalty deve ser um número.',
            'repetition_penalty.min' => 'O repetition_penalty deve ser maior ou igual a 0.1.',
            'repetition_penalty.max' => 'O repetition_penalty deve ser menor ou igual a 2.',
            'max_time.integer' => 'O max_time deve ser um número inteiro.',
            'max_time.min' => 'O max_time deve ser maior que 0.',
            'max_time.max' => 'O max_time deve ser menor ou igual a 120 segundos.'
        ];
    }
} 