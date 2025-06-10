<?php

namespace App\DTOs;

class HuggingFaceChatRequestDto
{
    public function __construct(
        public readonly string $question,
        public readonly ?string $model = 'microsoft/DialoGPT-medium',
        public readonly ?int $maxLength = 100,
        public readonly ?float $temperature = 0.7,
        public readonly ?bool $doSample = true,
        public readonly ?float $topP = null,
        public readonly ?int $topK = null,
        public readonly ?float $repetitionPenalty = null,
        public readonly ?int $maxTime = null
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            question: $data['question'],
            model: $data['model'] ?? 'microsoft/DialoGPT-medium',
            maxLength: $data['max_length'] ?? 100,
            temperature: $data['temperature'] ?? 0.7,
            doSample: $data['do_sample'] ?? true,
            topP: $data['top_p'] ?? null,
            topK: $data['top_k'] ?? null,
            repetitionPenalty: $data['repetition_penalty'] ?? null,
            maxTime: $data['max_time'] ?? null
        );
    }

    public function toHuggingFaceApiFormat(): array
    {
        $data = [
            'inputs' => $this->question,
            'parameters' => [
                'max_length' => $this->maxLength,
                'temperature' => $this->temperature,
                'do_sample' => $this->doSample
            ]
        ];

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

        return $data;
    }
} 