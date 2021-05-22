<?php

declare(strict_types=1);

namespace Bavix\DAgent;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Request;
use JsonException;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Message\ResponseInterface;

class Client
{
    private array $headers = [
        'Content-type' => 'application/json',
    ];

    public function __construct(
        private string $apiUrl,
        private
        private GuzzleClient $guzzleClient
    ) {
    }

    /**
     * @throws JsonException|ClientExceptionInterface
     */
    public function dispatchMessage(MessageDto $messageDto): ResponseInterface
    {
        return $this->dispatchMessages([$messageDto]);
    }

    /** @param array<MessageDto> $messages
     *
     * @throws JsonException|ClientExceptionInterface
     */
    public function dispatchMessages(array $messages): ResponseInterface
    {
        $body = json_encode(['data' => $messages], JSON_THROW_ON_ERROR);
        $request = new Request('POST', $this->apiUrl, $this->headers, $body);

        return $this->guzzleClient->send($request, ['timeout' => .1]);
    }
}
