<?php

declare(strict_types=1);

use Bavix\DAgent\Client;
use Bavix\DAgent\MessageDto;
use GuzzleHttp\Client as GuzzleClient;

include_once dirname(__DIR__) . '/vendor/autoload.php';

$guzzle = new GuzzleClient();
$client = new Client('http://localhost:1323/metrics', $guzzle);

$arr = [];
while (true) {
    $messageDto = new MessageDto(
        name: 'dagent_client',
        value: memory_get_usage(true),
        tags: [
            'hostname' => gethostname(),
            'pid' => (string) getmypid(),
        ],
    );

    $client->dispatchMessage($messageDto);
    $arr[] = 1;
    sleep(1);
}
