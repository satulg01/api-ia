<?php

namespace App\DTOs;

class OpenAIChatResponseDto
{
    public function __construct(
        public readonly string $content,
        public readonly string $model,
        public readonly ?int $promptTokens = null,
        public readonly ?int $completionTokens = null,
        public readonly ?int $totalTokens = null,
        public readonly ?string $finishReason = null
    ) {}

    public static function fromOpenAIApiResponse(array $response): self
    {
        $content = $response['choices'][0]['message']['content'] ?? '';
        $model = $response['model'] ?? 'unknown';
        $finishReason = $response['choices'][0]['finish_reason'] ?? null;
        
        $usage = $response['usage'] ?? [];
        $promptTokens = $usage['prompt_tokens'] ?? null;
        $completionTokens = $usage['completion_tokens'] ?? null;
        $totalTokens = $usage['total_tokens'] ?? null;

        return new self(
            content: $content,
            model: $model,
            promptTokens: $promptTokens,
            completionTokens: $completionTokens,
            totalTokens: $totalTokens,
            finishReason: $finishReason
        );
    }

    public function toArray(): array
    {
        return [
            'content' => $this->content,
            'model' => $this->model,
            'finish_reason' => $this->finishReason,
            'usage' => [
                'prompt_tokens' => $this->promptTokens,
                'completion_tokens' => $this->completionTokens,
                'total_tokens' => $this->totalTokens
            ]
        ];
    }
} 