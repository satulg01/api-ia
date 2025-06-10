<?php

namespace App\Services;

use App\DTOs\GroqChatRequestDto;
use App\DTOs\GroqChatResponseDto;
use Exception;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GroqChatService
{
    private const GROQ_API_URL = 'https://api.groq.com/openai/v1/chat/completions';
    
    private function getApiKey(): string
    {
        return config('services.groq.api_key', '');
    }

    public function chat(GroqChatRequestDto $requestDto): GroqChatResponseDto
    {
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->getApiKey(),
            ])
            ->timeout(30)
            ->post(self::GROQ_API_URL, $requestDto->toGroqApiFormat());

            if (!$response->successful()) {
                Log::error('Groq API Error', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                
                throw new Exception(
                    'Groq API request failed: ' . $response->status() . ' - ' . $response->body()
                );
            }

            $responseData = $response->json();
            
            return GroqChatResponseDto::fromGroqApiResponse($responseData);

        } catch (ConnectionException $e) {
            Log::error('Groq API Connection Error', ['error' => $e->getMessage()]);
            throw new Exception('Failed to connect to Groq API: ' . $e->getMessage());
        } catch (RequestException $e) {
            Log::error('Groq API Request Error', ['error' => $e->getMessage()]);
            throw new Exception('Groq API request error: ' . $e->getMessage());
        } catch (Exception $e) {
            Log::error('Groq Service Error', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
} 