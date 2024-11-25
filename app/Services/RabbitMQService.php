<?php

namespace App\Services;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQService
{
    private $connection;
    private $channel;

    public function __construct()
    {
        $this->connection = new AMQPStreamConnection(
            'rabbitmq',
            5672,
            'guest',
            'guest'
        );

        $this->channel = $this->connection->channel();

        $this->channel->queue_declare(
            'match_updates',
            false,
            false,              // durable = false
            false,
            false
        );
    }

    public function publishMatchUpdate($data)
    {
        $message = new AMQPMessage(
            json_encode($data),
            ['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]
        );
        $this->channel->basic_publish($message, '', 'match_updates');
    }

    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }
}
