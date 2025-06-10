<?php

namespace App\Http\Controllers;

use App\DTOs\GrokChatRequestDto;
use App\Http\Requests\GrokChatRequest;
use App\Services\GrokChatService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ChatController extends Controller
{
    public function __construct(
        private readonly GrokChatService $grokChatService
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
} 