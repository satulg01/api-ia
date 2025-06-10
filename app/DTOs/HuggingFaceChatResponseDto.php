<?php

namespace App\DTOs;

class HuggingFaceChatResponseDto
{
    public function __construct(
        public readonly string $content,
        public readonly string $model,
        public readonly ?array $warnings = null,
        public readonly ?float $processingTime = null
    ) {}

    public static function fromHuggingFaceApiResponse(array $response, string $model): self
    {
        // Hugging Face pode retornar diferentes formatos dependendo do modelo
        $content = '';
        
        if (isset($response[0]['generated_text'])) {
            // Para modelos de text generation
            $content = $response[0]['generated_text'];
        } elseif (isset($response[0]['translation_text'])) {
            // Para modelos de tradução
            $content = $response[0]['translation_text'];
        } elseif (isset($response[0]['summary_text'])) {
            // Para modelos de summarization
            $content = $response[0]['summary_text'];
        } elseif (isset($response['generated_text'])) {
            // Formato alternativo
            $content = $response['generated_text'];
        } elseif (is_string($response)) {
            // Resposta simples em string
            $content = $response;
        } elseif (isset($response[0]) && is_string($response[0])) {
            // Array de strings
            $content = $response[0];
        }

        $warnings = $response['warnings'] ?? null;
        $processingTime = $response['processing_time'] ?? null;

        return new self(
            content: $content,
            model: $model,
            warnings: $warnings,
            processingTime: $processingTime
        );
    }

    public function toArray(): array
    {
        return [
            'content' => $this->content,
            'model' => $this->model,
            'warnings' => $this->warnings,
            'processing_time' => $this->processingTime
        ];
    }
} 