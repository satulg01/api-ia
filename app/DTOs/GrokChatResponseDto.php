<?php

namespace App\DTOs;

class GrokChatResponseDto
{
    public function __construct(
        public readonly string $content,
        public readonly string $model,
        public readonly ?int $promptTokens = null,
        public readonly ?int $completionTokens = null,
        public readonly ?int $totalTokens = null
    ) {}

    public static function fromGrokApiResponse(array $response): self
    {
        $content = $response['choices'][0]['message']['content'] ?? '';
        $model = $response['model'] ?? 'unknown';
        
        $usage = $response['usage'] ?? [];
        $promptTokens = $usage['prompt_tokens'] ?? null;
        $completionTokens = $usage['completion_tokens'] ?? null;
        $totalTokens = $usage['total_tokens'] ?? null;

        return new self(
            content: $content,
            model: $model,
            promptTokens: $promptTokens,
            completionTokens: $completionTokens,
            totalTokens: $totalTokens
        );
    }

    public function toArray(): array
    {
        return [
            'content' => $this->content,
            'model' => $this->model,
            'usage' => [
                'prompt_tokens' => $this->promptTokens,
                'completion_tokens' => $this->completionTokens,
                'total_tokens' => $this->totalTokens
            ]
        ];
    }
} 