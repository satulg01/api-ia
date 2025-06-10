<?php

use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;

Route::post('/chat', [ChatController::class, 'chat']); 
Route::post('/groq-chat', [ChatController::class, 'groqChat']);
Route::post('/openai-chat', [ChatController::class, 'openaiChat']);
Route::post('/huggingface-chat', [ChatController::class, 'huggingFaceChat']);
Route::post('/chat/completions', [ChatController::class, 'chatCompletion']); 