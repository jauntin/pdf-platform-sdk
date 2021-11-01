<?php

namespace Jauntin\PdfPlatformSdk;

abstract class Request
{
    private Client $client;
    protected string $method;
    protected string $path;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function request(array $data): array
    {
        return $this->client->request($this->method, $this->path, $data);
    }
}
