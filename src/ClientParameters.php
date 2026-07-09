<?php

namespace Jauntin\PdfPlatformSdk;

class ClientParameters
{
    public string $location;

    public string $clientId;

    public string $clientSecret;

    /**
     * @param  array{location: string, clientId: string, clientSecret: string}  $parameters
     */
    public function __construct(array $parameters)
    {
        $this->location = $parameters['location'];
        $this->clientId = $parameters['clientId'];
        $this->clientSecret = $parameters['clientSecret'];
    }
}
