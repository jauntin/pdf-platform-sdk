<?php

namespace Jauntin\PdfPlatformSdk;

use JsonException;

abstract class Request
{
    private Client $client;
    protected string $method;
    protected string $path;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param RequestData $data
     * @return ResponseData
     */
    abstract public function request($data);

    /**
     * @throws Exceptions\FailedRequestException
     * @throws JsonException
     */
    protected function clientRequest(array $data): array
    {
        return $this->client->request($this->method, $this->path, $data);
    }
}
