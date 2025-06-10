<?php

namespace App\Services;

use App\DTOs\HuggingFaceChatRequestDto;
use App\DTOs\HuggingFaceChatResponseDto;
use Exception;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HuggingFaceChatService
{
    // private const HUGGINGFACE_API_BASE_URL = 'https://api-inference.huggingface.co/models/';
    private const HUGGINGFACE_API_BASE_URL = 'https://router.huggingface.co/hf-inference/models/LINK_TO_MODEL/v1/chat/completions';
    
    private function getApiKey(): string
    {
        return config('services.huggingface.api_key', '');
    }

    public function chat(HuggingFaceChatRequestDto $requestDto): HuggingFaceChatResponseDto
    {
        try {
            $apiUrl = str_replace('LINK_TO_MODEL', $requestDto->model, self::HUGGINGFACE_API_BASE_URL);
            
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->getApiKey(),
            ])
            ->timeout(60) // Hugging Face pode ser mais lento
            ->post($apiUrl, $requestDto->toHuggingFaceApiFormat());

            if (!$response->successful()) {
                Log::error('Hugging Face API Error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'model' => $requestDto->model
                ]);
                
                throw new Exception(
                    'Hugging Face API request failed: ' . $response->status() . ' - ' . $response->body()
                );
            }

            $responseData = $response->json();
            
            // Verificar se o modelo está carregando
            if (isset($responseData['error']) && str_contains($responseData['error'], 'loading')) {
                throw new Exception('Model is currently loading, please try again in a few moments: ' . $responseData['error']);
            }
            
            // Verificar outros erros
            if (isset($responseData['error'])) {
                throw new Exception('Hugging Face API error: ' . $responseData['error']);
            }
            
            return HuggingFaceChatResponseDto::fromHuggingFaceApiResponse($responseData, $requestDto->model);

        } catch (ConnectionException $e) {
            Log::error('Hugging Face API Connection Error', ['error' => $e->getMessage()]);
            throw new Exception('Failed to connect to Hugging Face API: ' . $e->getMessage());
        } catch (RequestException $e) {
            Log::error('Hugging Face API Request Error', ['error' => $e->getMessage()]);
            throw new Exception('Hugging Face API request error: ' . $e->getMessage());
        } catch (Exception $e) {
            Log::error('Hugging Face Service Error', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
} 