<?php

namespace App\DTOs;

class ChatCompletionRequestDto
{
    public function __construct(
        public readonly array $messages,
        public readonly string $model,
        public readonly bool $stream = false,
        public readonly ?float $temperature = null,
        public readonly ?int $maxTokens = null,
        public readonly ?float $topP = null,
        public readonly ?int $topK = null,
        public readonly ?float $repetitionPenalty = null,
        public readonly ?int $maxTime = null
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            messages: $data['messages'],
            model: $data['model'],
            stream: $data['stream'] ?? false,
            temperature: $data['temperature'] ?? null,
            maxTokens: $data['max_tokens'] ?? null,
            topP: $data['top_p'] ?? null,
            topK: $data['top_k'] ?? null,
            repetitionPenalty: $data['repetition_penalty'] ?? null,
            maxTime: $data['max_time'] ?? null
        );
    }

    public function toHuggingFaceApiFormat(): array
    {
        // Extrair o texto da primeira mensagem do usuário
        $userMessage = collect($this->messages)
            ->where('role', 'user')
            ->first();
        
        $text = '';
        if ($userMessage && isset($userMessage['content'])) {
            if (is_array($userMessage['content'])) {
                // Formato com array de content
                $textContent = collect($userMessage['content'])
                    ->where('type', 'text')
                    ->first();
                $text = $textContent['text'] ?? '';
            } else {
                // Formato simples com string
                $text = $userMessage['content'];
            }
        }

        $data = [
            'inputs' => $text,
            'parameters' => []
        ];

        if ($this->temperature !== null) {
            $data['parameters']['temperature'] = $this->temperature;
        }

        if ($this->maxTokens !== null) {
            $data['parameters']['max_length'] = $this->maxTokens;
        }

        if ($this->topP !== null) {
            $data['parameters']['top_p'] = $this->topP;
        }

        if ($this->topK !== null) {
            $data['parameters']['top_k'] = $this->topK;
        }

        if ($this->repetitionPenalty !== null) {
            $data['parameters']['repetition_penalty'] = $this->repetitionPenalty;
        }

        if ($this->maxTime !== null) {
            $data['parameters']['max_time'] = $this->maxTime;
        }

        // Adicionar do_sample se temperatura for especificada
        if ($this->temperature !== null) {
            $data['parameters']['do_sample'] = true;
        }

        return $data;
    }

    public function getFirstUserMessage(): string
    {
        $userMessage = collect($this->messages)
            ->where('role', 'user')
            ->first();
        
        if ($userMessage && isset($userMessage['content'])) {
            if (is_array($userMessage['content'])) {
                $textContent = collect($userMessage['content'])
                    ->where('type', 'text')
                    ->first();
                return $textContent['text'] ?? '';
            } else {
                return $userMessage['content'];
            }
        }

        return '';
    }
} 