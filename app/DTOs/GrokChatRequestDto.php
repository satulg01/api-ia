<?php

namespace App\DTOs;

class GrokChatRequestDto
{
    public function __construct(
        public readonly string $question,
        public readonly ?string $systemMessage = 'You are a helpful assistant.',
        public readonly ?float $temperature = 0.7,
        public readonly ?string $model = 'grok-3-latest'
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            question: $data['question'],
            systemMessage: $data['system_message'] ?? 'You are a helpful assistant.',
            temperature: $data['temperature'] ?? 0.7,
            model: $data['model'] ?? 'grok-3-latest'
        );
    }

    public function toGrokApiFormat(): array
    {
        return [
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
            'stream' => false,
            'temperature' => $this->temperature
        ];
    }
} 