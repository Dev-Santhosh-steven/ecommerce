<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Services\ChatbotService;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    public function message(Request $request, ChatbotService $chatbot)
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:300'],
        ]);

        return response()->json($chatbot->reply($validated['message']));
    }
}
