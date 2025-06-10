<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroqChatRequest extends FormRequest
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
            'model' => 'nullable|string|in:llama-3.3-70b-versatile,llama-3.1-8b-instant,llama-3.1-70b-versatile,gemma2-9b-it,mixtral-8x7b-32768',
            'max_tokens' => 'nullable|integer|min:1|max:8192'
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
            'model.in' => 'O modelo deve ser um dos seguintes: llama-3.3-70b-versatile, llama-3.1-8b-instant, llama-3.1-70b-versatile, gemma2-9b-it, mixtral-8x7b-32768.',
            'max_tokens.integer' => 'O max_tokens deve ser um número inteiro.',
            'max_tokens.min' => 'O max_tokens deve ser maior ou igual a 1.',
            'max_tokens.max' => 'O max_tokens deve ser menor ou igual a 8192.'
        ];
    }
} 