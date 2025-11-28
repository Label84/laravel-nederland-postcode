<?php

namespace Label84\NederlandPostcode\Resources;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Label84\NederlandPostcode\Exceptions\NederlandPostcodeException;
use Label84\NederlandPostcode\NederlandPostcodeClient;

class BaseResource
{
    protected PendingRequest $pendingRequest;

    public function __construct(
        protected NederlandPostcodeClient $nederlandPostcodeClient,
    ) {
        $this->pendingRequest = $this->nederlandPostcodeClient->makeRequest();
    }

    /**
     * @param  array<string, string|int|null|array<string>>  $query
     * @return array<mixed, mixed>
     */
    public function request(string $method, string $path, array $query = []): array
    {
        try {
            $response = $this->pendingRequest->send($method, $path, ['query' => $query]);

            return (array) $response->throw()->json();
        } catch (RequestException $exception) {
            throw new NederlandPostcodeException($exception->response);
        }
    }
}
