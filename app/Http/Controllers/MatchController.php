<?php

namespace App\Http\Controllers;

use App\Services\RabbitMQService;

class MatchController extends Controller
{
    public function sendUpdate(RabbitMQService $rabbitmq)
    {
        try {
            $data = [
                'type' => 'yellow_card',
                'player' => 'John Doe',
                'minute' => 65,
                'match_id' => 1,
                'timestamp' => time()
            ];

            $rabbitmq->publishMatchUpdate($data);

            return response()->json([
                'success' => true,
                'message' => 'Update sent yellow card!',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
