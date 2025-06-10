<?php

namespace App\Http\Controllers;

use App\DTOs\GrokChatRequestDto;
use App\DTOs\GroqChatRequestDto;
use App\DTOs\OpenAIChatRequestDto;
use App\DTOs\HuggingFaceChatRequestDto;
use App\DTOs\ChatCompletionRequestDto;
use App\Http\Requests\GrokChatRequest;
use App\Http\Requests\GroqChatRequest;
use App\Http\Requests\OpenAIChatRequest;
use App\Http\Requests\HuggingFaceChatRequest;
use App\Http\Requests\ChatCompletionRequest;
use App\Services\GrokChatService;
use App\Services\GroqChatService;
use App\Services\OpenAIChatService;
use App\Services\HuggingFaceChatService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ChatController extends Controller
{
    public function __construct(
        private readonly GrokChatService $grokChatService,
        private readonly GroqChatService $groqChatService,
        private readonly OpenAIChatService $openAIChatService,
        private readonly HuggingFaceChatService $huggingFaceChatService
    ) {}

    public function chat(GrokChatRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $data['system_message'] = 'You are a helpful assistant.';
            $requestDto = GrokChatRequestDto::fromArray($data);
            
            $response = $this->grokChatService->chat($requestDto);
            
            return response()->json([
                'success' => true,
                'data' => $response->toArray()
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to process chat request',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function groqChat(GroqChatRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $data['system_message'] = 'You are a helpful assistant.';
            $requestDto = GroqChatRequestDto::fromArray($data);
            
            $response = $this->groqChatService->chat($requestDto);
            
            return response()->json([
                'success' => true,
                'data' => $response->toArray()
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to process Groq chat request',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function openaiChat(OpenAIChatRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $data['system_message'] = 'You are a helpful assistant.';
            $requestDto = OpenAIChatRequestDto::fromArray($data);
            
            $response = $this->openAIChatService->chat($requestDto);
            
            return response()->json([
                'success' => true,
                'data' => $response->toArray()
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to process OpenAI chat request',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function huggingFaceChat(HuggingFaceChatRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $requestDto = HuggingFaceChatRequestDto::fromArray($data);
            
            $response = $this->huggingFaceChatService->chat($requestDto);
            
            return response()->json([
                'success' => true,
                'data' => $response->toArray()
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to process Hugging Face chat request',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function chatCompletion(ChatCompletionRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $requestDto = ChatCompletionRequestDto::fromArray($data);
            
            // Converter para o formato do HuggingFace e usar o serviço existente
            $huggingFaceData = [
                'question' => $requestDto->getFirstUserMessage(),
                'model' => $requestDto->model,
                'temperature' => $requestDto->temperature,
                'max_length' => $requestDto->maxTokens,
                'top_p' => $requestDto->topP,
                'top_k' => $requestDto->topK,
                'repetition_penalty' => $requestDto->repetitionPenalty,
                'max_time' => $requestDto->maxTime,
                'do_sample' => $requestDto->temperature !== null
            ];
            
            $huggingFaceDto = HuggingFaceChatRequestDto::fromArray($huggingFaceData);
            $response = $this->huggingFaceChatService->chat($huggingFaceDto);
            
            return response()->json([
                'success' => true,
                'data' => $response->toArray()
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to process chat completion request',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
} 