<?php

namespace App\Services;

use App\DTOs\GrokChatRequestDto;
use App\DTOs\GrokChatResponseDto;
use Exception;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GrokChatService
{
    private const GROK_API_URL = 'https://api.x.ai/v1/chat/completions';
    
    private function getApiKey(): string
    {
        return config('services.grok.api_key', '');
    }

    public function chat(GrokChatRequestDto $requestDto): GrokChatResponseDto
    {
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->getApiKey(),
            ])
            ->timeout(30)
            ->post(self::GROK_API_URL, $requestDto->toGrokApiFormat());

            if (!$response->successful()) {
                Log::error('Grok API Error', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                
                throw new Exception(
                    'Grok API request failed: ' . $response->status() . ' - ' . $response->body()
                );
            }

            $responseData = $response->json();
            
            return GrokChatResponseDto::fromGrokApiResponse($responseData);

        } catch (ConnectionException $e) {
            Log::error('Grok API Connection Error', ['error' => $e->getMessage()]);
            throw new Exception('Failed to connect to Grok API: ' . $e->getMessage());
        } catch (RequestException $e) {
            Log::error('Grok API Request Error', ['error' => $e->getMessage()]);
            throw new Exception('Grok API request error: ' . $e->getMessage());
        } catch (Exception $e) {
            Log::error('Grok Service Error', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
} 