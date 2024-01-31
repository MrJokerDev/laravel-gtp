<?php
namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Chat;

class ChatCreateService
{
    public function create($messages, $id)
    {
        return Chat::updateOrCreate(
            [
                'id' => $id,
            ],
            [
                'uuid' => Str::uuid()->toString(),
                'user_id' => Auth::id(),
                'context' => $messages
            ]

        );


    }
}
