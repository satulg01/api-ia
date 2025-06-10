<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChatCompletionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'messages' => 'required|array|min:1',
            'messages.*.role' => 'required|string|in:user,assistant,system',
            'messages.*.content' => 'required',
            'messages.*.content.*.type' => 'sometimes|string|in:text,image_url',
            'messages.*.content.*.text' => 'required_if:messages.*.content.*.type,text|string|max:4000',
            'model' => 'required|string|max:200',
            'stream' => 'nullable|boolean',
            'temperature' => 'nullable|numeric|min:0|max:2',
            'max_tokens' => 'nullable|integer|min:1|max:4096',
            'top_p' => 'nullable|numeric|min:0|max:1',
            'top_k' => 'nullable|integer|min:1|max:100',
            'repetition_penalty' => 'nullable|numeric|min:0.1|max:2',
            'max_time' => 'nullable|integer|min:1|max:120'
        ];
    }

    public function messages(): array
    {
        return [
            'messages.required' => 'As mensagens são obrigatórias.',
            'messages.array' => 'As mensagens devem ser um array.',
            'messages.min' => 'Deve haver pelo menos uma mensagem.',
            'messages.*.role.required' => 'O papel da mensagem é obrigatório.',
            'messages.*.role.in' => 'O papel deve ser user, assistant ou system.',
            'messages.*.content.required' => 'O conteúdo da mensagem é obrigatório.',
            'messages.*.content.*.type.in' => 'O tipo de conteúdo deve ser text ou image_url.',
            'messages.*.content.*.text.required_if' => 'O texto é obrigatório quando o tipo é text.',
            'messages.*.content.*.text.max' => 'O texto não pode ter mais de 4000 caracteres.',
            'model.required' => 'O modelo é obrigatório.',
            'model.string' => 'O modelo deve ser um texto.',
            'model.max' => 'O nome do modelo não pode ter mais de 200 caracteres.',
            'stream.boolean' => 'O stream deve ser verdadeiro ou falso.',
            'temperature.numeric' => 'A temperatura deve ser um número.',
            'temperature.min' => 'A temperatura deve ser maior ou igual a 0.',
            'temperature.max' => 'A temperatura deve ser menor ou igual a 2.',
            'max_tokens.integer' => 'O máximo de tokens deve ser um número inteiro.',
            'max_tokens.min' => 'O máximo de tokens deve ser maior que 0.',
            'max_tokens.max' => 'O máximo de tokens deve ser menor ou igual a 4096.',
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