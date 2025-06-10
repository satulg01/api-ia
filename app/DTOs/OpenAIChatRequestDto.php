<?php

namespace App\DTOs;

class OpenAIChatRequestDto
{
    public function __construct(
        public readonly string $question,
        public readonly ?string $systemMessage = 'You are a helpful assistant.',
        public readonly ?float $temperature = 0.7,
        public readonly ?string $model = 'gpt-3.5-turbo',
        public readonly ?int $maxTokens = null,
        public readonly ?float $topP = null,
        public readonly ?float $frequencyPenalty = null,
        public readonly ?float $presencePenalty = null
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            question: $data['question'],
            systemMessage: $data['system_message'] ?? 'You are a helpful assistant.',
            temperature: $data['temperature'] ?? 0.7,
            model: $data['model'] ?? 'gpt-3.5-turbo',
            maxTokens: $data['max_tokens'] ?? null,
            topP: $data['top_p'] ?? null,
            frequencyPenalty: $data['frequency_penalty'] ?? null,
            presencePenalty: $data['presence_penalty'] ?? null
        );
    }

    public function toOpenAIApiFormat(): array
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
            $data['max_tokens'] = $this->maxTokens;
        }

        if ($this->topP !== null) {
            $data['top_p'] = $this->topP;
        }

        if ($this->frequencyPenalty !== null) {
            $data['frequency_penalty'] = $this->frequencyPenalty;
        }

        if ($this->presencePenalty !== null) {
            $data['presence_penalty'] = $this->presencePenalty;
        }

        return $data;
    }
} 