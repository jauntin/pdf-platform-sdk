<?php

namespace Jauntin\PdfPlatformSdk;

use Jauntin\PdfPlatformSdk\Auth\CreateTokenRequest;
use Jauntin\PdfPlatformSdk\Exceptions\FailedRequestException;
use Illuminate\Support\Facades\Http;

class Client
{
    private ClientParameters $clientParameters;
    private string $accessToken = '';
    public function __construct(ClientParameters $clientParameters)
    {
        $this->clientParameters = $clientParameters;
        $this->authenticate();
    }

    public function request(string $method, string $path, array $data): array
    {
        $request = Http::asJson()->acceptJson();
        if ($this->accessToken) {
            $request->withToken($this->accessToken);
        }
        if ($data) {
            $request->bodyFormat('json');
            $request->withBody(json_encode($data), 'application/json');
        }
        $response = $request->send($method, $this->clientParameters->location . $path);
        if ($response->failed()) {
            throw new FailedRequestException('Unable to complete request', 0, $response->toException());
        }
        return $response->json();
    }

    private function authenticate()
    {
        $auth = resolve(CreateTokenRequest::class, ['client' => $this]);
        $response = $auth->request([
            'grant_type' => 'client_credentials',
            'client_id' => $this->clientParameters->clientId,
            'client_secret' => $this->clientParameters->clientSecret,
        ]);
        $this->accessToken = $response['access_token'];
    }
}
