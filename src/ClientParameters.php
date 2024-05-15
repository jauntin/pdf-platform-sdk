<?php

namespace Jauntin\PdfPlatformSdk;

class ClientParameters
{
    public string $location;
    public string $clientId;
    public string $clientSecret;

    /**
     * @param array<string,string> $parameters
     * @return void
     */
    public function __construct(array $parameters)
    {
        foreach ($parameters as $k => $v) {
            $this->{$k} = $v;
        }
    }
}
