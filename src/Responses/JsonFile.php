<?php

declare(strict_types=1);

namespace MockThirdApi\Responses;

final class JsonFile implements ResponseInterface
{
    private string $apiName;
    private string $jsonFilePath;

    private const JSON_PATH = '/%s/../data/%s/data.json';

    public function __construct(string $apiName)
    {
        $this->apiName = $apiName;
        $this->jsonFilePath = $this->normalizePath();
    }

    public function getResponses(): array
    {
        if (!realpath($this->jsonFilePath)) {
            http_response_code(404);
            echo sprintf('file not found for %s', $this->apiName);
            exit;
        }

        return json_decode(file_get_contents($this->jsonFilePath), true);
    }

    private function normalizePath(): string
    {
        return sprintf(self::JSON_PATH, dirname(__DIR__), $this->apiName);
    }
}
