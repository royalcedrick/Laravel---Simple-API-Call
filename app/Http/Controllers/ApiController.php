<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendMessageRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response as Response;
use Illuminate\Support\Str;

class ApiController extends Controller
{
    /**
     * empty string
     * @var string
     */
    const EMPTY_STRING = '';

    /**
     * Send message response
     * @param SendMessageRequest $request
     * @return JsonResponse
     */
    public function sendMessage(SendMessageRequest $request)
    {
        $getMessageContext = Str::of(strtolower($request->message))->match('/\b(hello|hi|goodbye|bye)\b/');
        if ($getMessageContext == self::EMPTY_STRING) {
            return $this->returnResponseMessage($request->conversation_id, 'Sorry, I don\'t understand.');
        }

        $responseMessage = $this->getResponseMessage($getMessageContext);
        return $this->returnResponseMessage($request->conversation_id, $responseMessage);

    }

    /**
     * Get response message based on context
     * @param $getMessageContext
     * @return string
     */
    private function getResponseMessage($getMessageContext): string
    {
        $responseMessage = self::EMPTY_STRING;
        switch ($getMessageContext) {
            case 'hello':
            case 'hi':
                $responseMessage = 'Welcome to StationFive.';
                break;
            case 'goodbye':
            case 'bye':
                $responseMessage = 'Thank you, see you around.';
                break;
        }

        return $responseMessage;
    }

    /**
     * Return response with message
     * @param $conversation_id
     * @param $message
     * @return JsonResponse
     */
    private function returnResponseMessage($conversation_id, $message): JsonResponse
    {
        return Response::json([
            'response_id' => $conversation_id,
            'response'    => $message,
        ], 200);
    }
}
