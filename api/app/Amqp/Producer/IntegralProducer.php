<?php

declare(strict_types=1);

namespace App\Amqp\Producer;

use Hyperf\Amqp\Annotation\Producer;
use Hyperf\Amqp\Message\ProducerMessage;

/**
 * @Producer(exchange="openapi_integral", routingKey="openapi_integral_queue")
 */
#[Producer(exchange: 'openapi_integral', routingKey: 'openapi_integral_queue')]
class IntegralProducer extends ProducerMessage
{
    public function __construct($data)
    {
        $this->payload = $data;
    }
}
