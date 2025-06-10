<?php

namespace App\Services;

use App\DTOs\OpenAIChatRequestDto;
use App\DTOs\OpenAIChatResponseDto;
use Exception;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OpenAIChatService
{
    private const OPENAI_API_URL = 'https://api.openai.com/v1/chat/completions';
    
    private function getApiKey(): string
    {
        return config('services.openai.api_key', '');
    }

    public function chat(OpenAIChatRequestDto $requestDto): OpenAIChatResponseDto
    {
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->getApiKey(),
            ])
            ->timeout(30)
            ->post(self::OPENAI_API_URL, $requestDto->toOpenAIApiFormat());

            if (!$response->successful()) {
                Log::error('OpenAI API Error', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                
                throw new Exception(
                    'OpenAI API request failed: ' . $response->status() . ' - ' . $response->body()
                );
            }

            $responseData = $response->json();
            
            return OpenAIChatResponseDto::fromOpenAIApiResponse($responseData);

        } catch (ConnectionException $e) {
            Log::error('OpenAI API Connection Error', ['error' => $e->getMessage()]);
            throw new Exception('Failed to connect to OpenAI API: ' . $e->getMessage());
        } catch (RequestException $e) {
            Log::error('OpenAI API Request Error', ['error' => $e->getMessage()]);
            throw new Exception('OpenAI API request error: ' . $e->getMessage());
        } catch (Exception $e) {
            Log::error('OpenAI Service Error', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
} 