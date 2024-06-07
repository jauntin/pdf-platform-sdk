<?php

namespace Jauntin\PdfPlatformSdk;

use Jauntin\PdfPlatformSdk\Exceptions\FailedRequestException;

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
     * @param  RequestData  $data
     * @return ResponseData
     */
    abstract public function request($data);

    /**
     * @param  array<mixed>  $data
     * @return array<mixed>
     *
     * @throws FailedRequestException
     */
    protected function clientRequest(array $data): array
    {
        return $this->client->request($this->method, $this->path, $data);
    }
}
