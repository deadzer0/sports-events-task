<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class ConsumeMatchUpdates extends Command
{
    protected $signature = 'rabbitmq:consume';
    protected $description = 'Consume match updates from RabbitMQ';

    /**
     * @throws \Exception
     */
    public function handle()
    {
        $connection = new AMQPStreamConnection(
            env('RABBITMQ_HOST', 'rabbitmq'),
            env('RABBITMQ_PORT', 5672),
            env('RABBITMQ_USER', 'guest'),
            env('RABBITMQ_PASSWORD', 'guest')
        );

        $channel = $connection->channel();
        $channel->queue_declare('match_updates', false, false, false, false);

        echo " [*] Waiting for messages. To exit press CTRL+C\n";

        $callback = function ($msg) {
            $data = json_decode($msg->body, true);
            echo " [x] Received update: " . print_r($data, true) . "\n";
            // Тук ще добавим код за изпращане към браузъра по-късно
        };

        $channel->basic_consume('match_updates', '', false, true, false, false, $callback);

        while (count($channel->callbacks)) {
            $channel->wait();
        }

        $channel->close();
        $connection->close();
    }


}
