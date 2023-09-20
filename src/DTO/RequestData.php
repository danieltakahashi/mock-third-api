<?php

declare(strict_types=1);

namespace MockThirdApi\DTO;

readonly class RequestData
{
    private string $apiName;
    private string $apiPath;
    private string $httpMethod;

    public function __construct(string $apiName, string $apiPath, string $httpMethod)
    {
        $this->apiName = $apiName;
        $this->apiPath = $apiPath;
        $this->httpMethod = $httpMethod;
    }

    public function getApiName(): string
    {
        return $this->apiName;
    }

    public function getApiPath(): string
    {
        return $this->apiPath;
    }

    public function getHttpMethod(): string
    {
        return $this->httpMethod;
    }
}
