<?php

namespace App\DTOs;

class GroqChatRequestDto
{
    public function __construct(
        public readonly string $question,
        public readonly ?string $systemMessage = 'You are a helpful assistant.',
        public readonly ?float $temperature = 0.7,
        public readonly ?string $model = 'llama-3.3-70b-versatile',
        public readonly ?int $maxTokens = null
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            question: $data['question'],
            systemMessage: $data['system_message'] ?? 'You are a helpful assistant.',
            temperature: $data['temperature'] ?? 0.7,
            model: $data['model'] ?? 'llama-3.3-70b-versatile',
            maxTokens: $data['max_tokens'] ?? null
        );
    }

    public function toGroqApiFormat(): array
    {
        $data = [
            'messages' => [
                [
                    'role' => 'system',
                    'content' => $this->systemMessage
                ],
                [
                    'role' => 'user',
                    'content' => $this->question
                ]
            ],
            'model' => $this->model,
            'temperature' => $this->temperature
        ];

        if ($this->maxTokens !== null) {
            $data['max_completion_tokens'] = $this->maxTokens;
        }

        return $data;
    }
} 