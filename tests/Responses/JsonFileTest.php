<?php 
declare(strict_types=1);

namespace tests\Responses;

use MockThirdApi\Responses\JsonFile;
use PHPUnit\Framework\TestCase;

final class JsonFileTest extends TestCase
{

    public function testGetResponsesReturnArrayIfExistsJsonFile(): void
    {
        $jsonFile = new JsonFile(apiName: 'domain.sample');
        $responses = $jsonFile->getResponses();

        $this->assertEquals($this->getExpectedResponseForDomainSample(), $responses);
    }

    private function getExpectedResponseForDomainSample(): array
    {
        return json_decode('[
            {
                "method": "GET",
                "path": "/test1",
                "response": {
                    "statusCode": 202,
                    "body": {
                        "result_code": 1234,
                        "result_message": "test1 working"
                    }
                }
            },
            {
                "method": "GET",
                "path": "/test2",
                "response": {
                    "statusCode": 200,
                    "body": {
                        "result_code": 1234,
                        "result_message": "test2 working"
                    }
                }
            }
        ]', true);
    }
}