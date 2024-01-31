<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreChatRequest;
use App\Models\Chat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use OpenAI\Laravel\Facades\OpenAI;

class ChatController extends Controller
{
    public function index(string $uuid = null)
    {
        return response()->json([
//            'chat' => fn () => $uuid ? Chat::find($uuid) : null,
            'messages' => Chat::latest()->where('uuid', $uuid)->get()
        ]);
    }

    public function store(StoreChatRequest $request, string $uuid = null)
    {
        $messages = [];
        if ($uuid !== null) {
            $chat = Chat::find($uuid);
            $messages = $chat->context;
        }

        $messages[] = ['role' => 'user', 'content' => $request->input('promt')];

        $response = OpenAI::chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => $messages
        ]);

        $messages[] = ['role' => 'assistant', 'content' => $response->choices[0]->message->content];

        $chat = Chat::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'uuid' => Str::uuid()->toString(),
            ],
            [
                'context' => $messages
            ]
        );
        return response()->json([
            'chat' => $chat
        ]);
    }

    public function destroy(Chat $chat)
    {
        $chat->delete();
        return redirect()->route('chat.show');
    }
}
